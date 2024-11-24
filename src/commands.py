"""Fichier de création des commandes flask"""
import click
from src.app import app, db
from hashlib import sha256
from .models import *

# from src.database import Action


# @app.cli.command()
# def syncdb() -> None:
#     """Crée les tables manquantes
#     """
#     db.create_all()

