#!/usr/bin/env python

import os
import json
from flask import Flask, request, send_file, send_from_directory, jsonify
from werkzeug.utils import secure_filename
from plot_image import generate_plot_image

app = Flask(__name__)

# Configura la carpeta para cargar archivos
UPLOAD_FOLDER = 'uploads'
ALLOWED_EXTENSIONS = {'csv'}
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Función para verificar la extensión permitida del archivo
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route("/")
def index():
    return "Usage: http://<hostname>[:<prt>]/api/<url>"

@app.route("/api/generate_plot", methods=["POST"])
def generate_plot():
    img_path = None
    if request.method == "POST":
        file = request.files["filename"]
        if file and allowed_file(file.filename):
            # Guarda el archivo CSV en la carpeta 'uploads'
            filename = secure_filename(file.filename)
            csv_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
            file.save(csv_path)

            # Genera la imagen y obtiene la ruta
            img_path = generate_plot_image(csv_path)
            print(f"Generated image path: {img_path}")

    # Return JSON response
    response_data = {"img_path": img_path}
    return jsonify(response_data)

@app.route("/api/img/<filename>")
def view_image(filename):
    img_path = os.path.join("img", filename)
    return send_from_directory("img", filename)

if __name__ == "__main__":
    app.run(host="0.0.0.0")
