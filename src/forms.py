"""
Fichier contenant les différents formulaires de l'application
"""
from .models import *

from flask_wtf import FlaskForm
from wtforms import StringField, SelectField, PasswordField, HiddenField, SubmitField, IntegerField, TextAreaField
from wtforms.validators import DataRequired, Optional
from hashlib import sha256
