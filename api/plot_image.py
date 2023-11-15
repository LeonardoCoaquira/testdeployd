#!/usr/bin/env python

import os
import pandas as pd
import plotly.graph_objs as go
from plotly.offline import plot, iplot

def generate_plot_image(csv_path, img_folder='img/'):
    # Lee los datos del archivo CSV
    ratings = pd.read_csv(csv_path)

    # Crear el gráfico con Plotly
    data = ratings['rating'].value_counts().sort_index(ascending=False)
    trace = go.Bar(
        x=data.index,
        text=['{:.1f} %'.format(val) for val in (data.values / ratings.shape[0] * 100)],
        textposition='auto',
        textfont=dict(color='#000000'),
        y=data.values,
    )

    # Crear el diseño del gráfico
    layout = dict(title='Distribution Of {} ratings'.format(ratings.shape[0]),
                  xaxis=dict(title='Rating'),
                  yaxis=dict(title='Count'))

    # Crear la figura
    fig = go.Figure(data=[trace], layout=layout)

    # Verifica si la carpeta existe, y si no, créala
    if not os.path.exists(img_folder):
        os.makedirs(img_folder)

    # Guardar la figura como imagen
    img_path = os.path.join(img_folder, 'generated_plot.png')
    fig.write_image(img_path)

    return img_path