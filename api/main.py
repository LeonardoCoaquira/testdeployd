#!/usr/bin/env python

import os
import json
import redis
from flask import Flask
from flask import request
from linkextractor import extract_links

app = Flask(__name__)
redis_conn = redis.from_url(os.getenv("REDIS_URL", "redis://localhost:6379"))

@app.route("/")
def index():
    return "Usage: http://<hostname>[:<prt>]/api/<url>"

@app.route("/api/<path:url>")
def api(url):
    qs = request.query_string.decode("utf-8")
    if qs != "":
        url += "?" + qs

    jsonlinks = redis_conn.get(url)
    if not jsonlinks:
        links = extract_links(url)
        jsonlinks = json.dumps(links, indent=2)
        redis_conn.set(url, jsonlinks)

    response = app.response_class(
        status=200,
        mimetype="application/json",
        response=jsonlinks
    )

    return response

@app.route("/api/generate_plot/<filename>")
def generate_plot(filename):
    csv_path = f'data/{filename}'
    img_path = generate_plot_image(csv_path)
    return send_file(img_path, mimetype='image/png')

app.run(host="0.0.0.0")
