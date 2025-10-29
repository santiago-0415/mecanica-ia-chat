import os
from flask import Flask, request, jsonify
from flask_cors import CORS
from google import genai
from google.genai import types 
from google.genai import errors # Importado para manejo específico de errores

# ----------------------------------------------------
# CONFIGURACIÓN DEL CHAT CON MEMORIA (GLOBAL)
# ----------------------------------------------------

# Instrucción para definir el rol del asistente (System Instruction)
SYSTEM_INSTRUCTION = (
    "Eres el asistente IA del 'Taller Mecánico Servicio Automotriz Flores'. "
    "Tu rol es responder preguntas de los clientes sobre diagnósticos, "
    "mantenimiento preventivo, y servicios de mecánica general (transmisiones, afinaciones, etc.). "
    "Mantén un tono profesional, amigable y técnico, enfocado en resolver las dudas del cliente."
)

app = Flask(__name__)
CORS(app) 

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
         print("ERROR: La variable de entorno GEMINI_API_KEY no está configurada. Usa 'export GEMINI_API_KEY=...'")


# --- Rutas de la API ---

@app.route("/health", methods=["GET"])
def health_check():
    """Ruta de diagnóstico para verificar que el servidor está activo."""
    return jsonify({
        "status": "ok",
        "message": "Servidor de IA está corriendo y listo."
    })

# ... (cerca de la línea 48, debajo de health_check)

@app.route("/health", methods=["GET"])
def health_check():
    """Ruta de diagnóstico para verificar que el servidor está activo."""
    return jsonify({
        "status": "ok",
        "message": "Servidor de IA está corriendo y listo."
    })

@app.route("/gemini-reset", methods=["POST"]) # <--- ¡NUEVA RUTA!
def reset_chat():
    """Ruta para reiniciar la sesión de chat y limpiar la memoria."""
    global global_chat
    try:
        # Crea un nuevo objeto de chat con las mismas instrucciones del sistema
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
# ...

@app.route("/gemini-chat", methods=["POST"])
def gemini_chat():
    """Ruta principal para enviar mensajes a Gemini con historial."""
    
    # 1. Obtener el prompt del cuerpo de la solicitud JSON
    try:
        data = request.get_json()
        prompt = data.get("prompt", "")
        if not prompt:
            return jsonify({"reply": "Error: No se encontró el prompt en la solicitud."}), 400
    except Exception:
        return jsonify({"reply": "Error: Formato JSON inválido."}), 400

    # 2. Llamada a Gemini usando el objeto de chat (con memoria)
    try:
        # Usa global_chat.send_message para mantener el historial
        response = global_chat.send_message(prompt)
        
        # 3. Devolver la respuesta al frontend
        return jsonify({"reply": response.text})

    # 4. Manejo avanzado de errores
    except errors.ResourceExhaustedError as e:
        # Error específico de cuota agotada
        print(f"Error de Cuota Agotada: {e}")
        return jsonify({
            "reply": "Nuestro asistente IA ha alcanzado su límite de uso por hoy. Por favor, llámanos para resolver tu consulta."
        }), 429 # Demasiadas solicitudes
        
    except errors.APIError as e:
        # Esto captura errores de la API (ej: clave inválida, modelo no encontrado)
        print(f"Error de API (4xx o 5xx): {e}")
        return jsonify({
            "reply": "Parece que la clave API ha expirado o hay un problema en la configuración. Llama al taller para asistencia."
        }), 503 # Servicio no disponible
        
    except errors.ClientError as e:
        # Errores que no son del servidor (ej: red, timeout, problema de conexión)
        print(f"Error de Cliente/Conexión: {e}")
        return jsonify({
            "reply": "Hubo un problema de conexión. Intenta recargar la página o llama al taller."
        }), 504 # Timeout o Gateway Error
        
    except Exception as e:
        # Cualquier otro error inesperado (ej: error en el servidor Flask)
        print(f"Error Desconocido: {e}")
        return jsonify({
            "reply": "Ocurrió un error interno inesperado. Por favor, inténtalo más tarde o llama directamente."
        }), 500

if __name__ == "__main__":
    # Asegúrate de que Flask corra en el mismo puerto que tu JavaScript espera
    # Si la vez anterior fue 5000 y funcionó, úsalo. Si no, usa 5001.
    app.run(debug=False, port=5001)