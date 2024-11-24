"""Fichier contenant les vues de l'application"""
from src.models import *
from src.forms import *
from src.app import app, db

from hashlib import sha256

from flask import jsonify, render_template, url_for, redirect, make_response, request
from flask_login import login_user, current_user, logout_user, login_required

import json
import os
from werkzeug.utils import secure_filename

# Redirection pages erreurs


# @app.errorhandler(404)
# def page_not_found(e):
#     return redirect(url_for('not_found', message=e))


# @app.route("/NotFound/<message>")
# def not_found(message="Not Found"):
#     print(message)
#     return render_template("404.html")
