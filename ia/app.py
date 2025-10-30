import os
from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS
from google import genai
from google.genai import types 
from google.genai import errors

# ----------------------------------------------------
# AJUSTE DE RUTAS Y CONFIGURACIÓN DE FLASK
# ----------------------------------------------------

# Obtenemos la ruta absoluta de la carpeta 'ia' (donde está app.py)
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# La carpeta de front-end está un nivel arriba ('..') y luego en 'front-end'
FRONT_END_DIR = os.path.join(BASE_DIR, '..', 'front-end')

# Inicializamos Flask, diciéndole que la carpeta estática es 'front-end'
app = Flask(
    __name__, 
    static_folder=FRONT_END_DIR 
) 
CORS(app) 

# ----------------------------------------------------
# CONFIGURACIÓN DEL CHAT CON MEMORIA (GLOBAL)
# ----------------------------------------------------

SYSTEM_INSTRUCTION = (
    "Eres el asistente IA del 'Taller Mecánico Servicio Automotriz Flores'. "
    "Tu rol es responder preguntas de los clientes sobre diagnósticos, "
    "mantenimiento preventivo, y servicios de mecánica general (transmisiones, afinaciones, etc.). "
    "Mantén un tono profesional, amigable y técnico, enfocado en resolver las dudas del cliente."
)

# Inicialización del cliente y la sesión de chat con memoria
try:
    # El cliente busca la clave en la variable de entorno GEMINI_API_KEY
    client = genai.Client()
    
    # Crea la sesión de chat global para mantener la memoria
    global_chat = client.chats.create(
        model="gemini-2.5-flash",
        config=types.GenerateContentConfig(
            system_instruction=SYSTEM_INSTRUCTION
        )
    )
    print("Cliente de Gemini inicializado correctamente. Chat con memoria listo.")
except Exception as e:
    print(f"Error al inicializar el cliente de Gemini: {e}")
    if 'GEMINI_API_KEY' not in os.environ:
         print("ERROR: La variable de entorno GEMINI_API_KEY no está configurada.")

# ----------------------------------------------------
# RUTAS PARA SERVIR EL FRONT-END (HTML, CSS, JS)
# ----------------------------------------------------

@app.route('/')
def serve_index():
    """Sirve el archivo index.html cuando alguien visita la URL principal."""
    # Flask buscará 'index.html' en la carpeta FRONT_END_DIR
    return app.send_static_file('index.html')

@app.route('/<path:filename>')
def serve_static(filename):
    """Sirve archivos estáticos (CSS, JS, imágenes) desde la carpeta front-end."""
    # Flask buscará cualquier otro archivo (ej. styles.css) en la carpeta FRONT_END_DIR.
    return app.send_static_file(filename)

# ----------------------------------------------------
# RUTAS DE LA API (TU LÓGICA DE NEGOCIO)
# ----------------------------------------------------

@app.route("/health", methods=["GET"])
def health_check():
    """Ruta de diagnóstico para verificar que el servidor está activo."""
    return jsonify({
        "status": "ok",
        "message": "Servidor de IA está corriendo y listo."
    })

@app.route("/gemini-reset", methods=["POST"])
def reset_chat():
    """Ruta para reiniciar la sesión de chat y limpiar la memoria."""
    global global_chat
    try:
        global_chat = client.chats.create(
            model="gemini-2.5-flash",
            config=types.GenerateContentConfig(
                system_instruction=SYSTEM_INSTRUCTION
            )
        )
        print("Chat de Gemini reiniciado (memoria limpia).")
        return jsonify({"status": "ok", "reply": "Nuevo chat iniciado."})
    except Exception as e:
        print(f"Error al reiniciar el chat: {e}")
        return jsonify({"status": "error", "reply": "No se pudo reiniciar el chat."}), 500

@app.route("/gemini-chat", methods=["POST"])
def gemini_chat():
    """Ruta principal para enviar mensajes a Gemini con historial."""
    
    try:
        data = request.get_json()
        prompt = data.get("prompt", "")
        if not prompt:
            return jsonify({"reply": "Error: No se encontró el prompt en la solicitud."}), 400
    except Exception:
        return jsonify({"reply": "Error: Formato JSON inválido."}), 400

    try:
        response = global_chat.send_message(prompt)
        return jsonify({"reply": response.text})

    # Manejo de errores (mantuvimos tu lógica original para errores)
    except errors.ResourceExhaustedError as e:
        print(f"Error de Cuota Agotada: {e}")
        return jsonify({
            "reply": "Nuestro asistente IA ha alcanzado su límite de uso por hoy. Por favor, llámanos para resolver tu consulta."
        }), 429
        
    except errors.APIError as e:
        print(f"Error de API (4xx o 5xx): {e}")
        return jsonify({
            "reply": "Parece que la clave API ha expirado o hay un problema en la configuración. Llama al taller para asistencia."
        }), 503
        
    except errors.ClientError as e:
        print(f"Error de Cliente/Conexión: {e}")
        return jsonify({
            "reply": "Hubo un problema de conexión. Intenta recargar la página o llama al taller."
        }), 504
        
    except Exception as e:
        print(f"Error Desconocido: {e}")
        return jsonify({
            "reply": "Ocurrió un error interno inesperado. Por favor, inténtalo más tarde o llama directamente."
        }), 500

if __name__ == "__main__":
    app.run(debug=False, port=5001)

# Fin del archivo ia/app.py