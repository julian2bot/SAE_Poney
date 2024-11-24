"""
Créateur de fichier SQLalchemy
"""
import os.path
from flask import Flask
from flask_bootstrap import Bootstrap5
from flask_sqlalchemy import SQLAlchemy
from flask_login import LoginManager


def make_path(fichier_destination: str) -> str:
    """Créer le chemin vers le fichier destination pour la base de donnée

    Args:
        fichier_destination (str): nom du fichier destination

    Returns:
        str: chemin vers le fichier destination
    """
    return os.path.normpath(
        os.path.join(os.path.dirname(__file__), fichier_destination))


app = Flask(__name__)
app.config["BOOTSTRAP_SERV_LOCAL"] = True
bootstrap = Bootstrap5(app)

app.config["SECRET_KEY"] = "8669704c-504a-4707-aab3-fd8e561ff1bc"
app.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///" + make_path("../myapp.db")
db = SQLAlchemy(app)
login_manager = LoginManager(app)
login_manager.login_view = "login"
