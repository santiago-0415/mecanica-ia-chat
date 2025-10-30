import os
from flask import Flask, request, jsonify, send_from_directory
from flask_cors import CORS
# ... (resto de tus imports)

# ----------------------------------------------------
# AJUSTE DE RUTAS Y CONFIGURACIÓN DE FLASK
# ----------------------------------------------------

# Obtenemos la ruta absoluta de la carpeta 'ia'
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# La carpeta de front-end está un nivel arriba ('..') y luego en 'front-end'
FRONT_END_DIR = os.path.join(BASE_DIR, '..', 'front-end')

# La carpeta de imágenes está un nivel arriba ('..') y luego en 'imagenes'
IMAGENES_DIR = os.path.join(BASE_DIR, '..', 'imagenes')

# Inicializamos Flask, diciéndole que la carpeta estática es 'front-end'
# Nota: La carpeta 'imagenes' la serviremos con una ruta personalizada
app = Flask(
    __name__, 
    static_folder=FRONT_END_DIR 
) 
CORS(app) 

# ... (Todo tu código de configuración de Gemini va aquí) ...

# ----------------------------------------------------
# RUTAS PARA SERVIR EL FRONT-END (HTML, CSS, JS)
# ----------------------------------------------------

@app.route('/')
def serve_index():
    """Sirve el archivo index.html (y el JS incrustado)."""
    return app.send_static_file('index.html')

@app.route('/<path:filename>')
def serve_static(filename):
    """Sirve archivos estáticos (CSS, JS, etc.) desde la carpeta front-end."""
    return app.send_static_file(filename)

# ----------------------------------------------------
# NUEVA RUTA PARA SERVIR IMÁGENES (¡CRUCIAL!)
# ----------------------------------------------------

@app.route('/imagenes/<path:filename>')
def serve_images(filename):
    """
    Sirve archivos estáticos desde la carpeta 'imagenes'.
    Esta ruta coincide con las llamadas de tu HTML: <img src="../imagenes/logo.jpeg">
    """
    # Usamos send_from_directory para servir desde la carpeta IMAGENES_DIR
    return send_from_directory(IMAGENES_DIR, filename)

# ... (El resto de tus rutas /health, /gemini-reset, /gemini-chat van aquí) ...

if __name__ == "__main__":
    # Nota: Render usa el puerto 80, pero para pruebas locales puedes usar 5001
    app.run(debug=False, port=5001)