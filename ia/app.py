import os
import json
from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS
from google import genai
from google.genai import types

# ----------------------------------------------------
# 1. DEFINICIÓN DE VARIABLES GLOBALES Y CONFIGURACIÓN
# ----------------------------------------------------

# Variables que se inicializarán más tarde para ser accesibles globalmente
client = None
chat = None
SYSTEM_INSTRUCTION = ""
IMAGENES_DIR = ""

# Obtenemos la ruta absoluta de la carpeta 'ia' (donde está app.py)
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# La clave API se lee de la variable de entorno de Render
API_KEY = os.environ.get("GEMINI_API_KEY")

# Definimos el contexto inicial (system instruction)
SYSTEM_INSTRUCTION = (
    "Eres un asistente de inteligencia artificial llamado Taller IA especializado en mecánica automotriz. "
    "Tu objetivo es dar diagnósticos y consejos a clientes con problemas en su vehículo. "
    "Mantén un tono profesional, amable y técnico, pero fácil de entender. "
    "NO eres un humano, recuérdalo."
)


# ----------------------------------------------------
# 2. FUNCIÓN DE INICIALIZACIÓN DEL SERVIDOR Y LA IA
# ----------------------------------------------------

def initialize_app():
    global client, chat, IMAGENES_DIR

    # A. Configuración de Rutas de Directorio
    
    # La carpeta de front-end está un nivel arriba ('..') y luego en 'front-end'
    FRONT_END_DIR = os.path.join(BASE_DIR, '..', 'front-end')

    # La carpeta de imágenes está un nivel arriba ('..') y luego en 'imagenes'
    IMAGENES_DIR = os.path.join(BASE_DIR, '..', 'imagenes') # Corregido error de ámbito aquí

    # B. Inicialización de Flask
    
    # Inicializamos Flask, diciéndole que la carpeta estática es 'front-end'
    app = Flask(
        __name__, 
        static_folder=FRONT_END_DIR 
    ) 
    CORS(app) 

    # C. Inicialización de Gemini
    
    if not API_KEY:
        print("ADVERTENCIA: La clave GEMINI_API_KEY no está configurada.")
        client = None
    else:
        try:
            client = genai.Client(api_key=API_KEY)
            chat = client.chats.create(
                model="gemini-2.5-flash",
                system_instruction=SYSTEM_INSTRUCTION
            )
            print("Chat de Gemini inicializado con éxito.")
        except Exception as e:
            print(f"Error al inicializar el cliente de Gemini: {e}")
            client = None
            
    return app


# Inicializamos la aplicación llamando a la función
app = initialize_app()


# ----------------------------------------------------
# 3. RUTAS DE FLASK (Finales y Corregidas)
# ----------------------------------------------------

# A. RUTAS PARA SERVIR EL FRONT-END

@app.route('/')
def serve_index():
    """Sirve el archivo index.html."""
    return app.send_static_file('index.html')

@app.route('/<path:filename>')
def serve_static(filename):
    """Sirve archivos estáticos (CSS, JS, etc.) desde la carpeta front-end."""
    return app.send_static_file(filename)

@app.route('/imagenes/<path:filename>')
def serve_images(filename):
    """
    Sirve archivos estáticos desde la carpeta 'imagenes'.
    Soluciona el problema de las imágenes que no cargaban.
    """
    global IMAGENES_DIR # Aseguramos que la variable global esté en uso
    # Corregido error de ámbito aquí (línea 139 aproximadamente)
    return send_from_directory(IMAGENES_DIR, filename) 


# B. RUTAS DE LA API (POST añadido para Error 405)

@app.route('/gemini-chat', methods=['POST'])
def gemini_chat():
    """Maneja la conversación con Gemini."""
    global client, chat

    if not client:
        return jsonify({"error": "El servidor de IA no está disponible."}), 500

    try:
        data = request.get_json()
        user_message = data.get('message', '')

        if not user_message:
            return jsonify({"error": "Mensaje de usuario vacío."}), 400

        response = chat.send_message(user_message)
        return jsonify({"response": response.text})

    except Exception as e:
        return jsonify({"error": f"Error interno del servidor de IA: {e}"}), 500


@app.route('/gemini-reset', methods=['POST'])
def gemini_reset():
    """Reinicia el historial de la conversación."""
    global client, chat # Indicamos que vamos a modificar las variables globales

    if not client:
        return jsonify({"status": "Servidor de IA no disponible, no se pudo resetear."})

    try:
        # Crea una nueva instancia de chat con el contexto original
        chat = client.chats.create(
            model="gemini-2.5-flash",
            system_instruction=SYSTEM_INSTRUCTION
        )
        return jsonify({"status": "Conversación reiniciada con éxito."})

    except Exception as e:
        return jsonify({"status": f"Error al intentar reiniciar la conversación: {e}"}), 500

# C. RUTA DE VERIFICACIÓN DE ESTADO

@app.route('/health')
def health_check():
    """Verifica si el servidor está activo."""
    return jsonify({"status": "ok", "service": "mecanica-ia-chat"})


# ----------------------------------------------------
# 4. EJECUCIÓN DEL SERVIDOR
# ----------------------------------------------------

if __name__ == "__main__":
    # Esta parte solo se ejecuta en local, Gunicorn la ignora en Render
    app.run(debug=True, port=5001)