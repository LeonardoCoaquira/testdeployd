FROM       python:3
LABEL      maintainer="Sawood Alam <@ibnesayeed>"

ENV        REDIS_URL="redis://localhost:6379"

WORKDIR    /app
RUN        pip install --upgrade pip

COPY       requirements.txt /app/
RUN        pip install -r requirements.txt

COPY       *.py /app/
RUN        chmod a+x *.py

CMD        ["./main.py"]
