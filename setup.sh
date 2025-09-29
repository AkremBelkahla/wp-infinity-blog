#!/bin/bash

# Script d'installation pour Infinity Blog Theme
echo "Installation de l'environnement de développement pour Infinity Blog Theme..."

# Vérifier si Node.js est installé
if ! command -v node &> /dev/null; then
    echo "Node.js n'est pas installé. Veuillez installer Node.js (v14 ou supérieur) avant de continuer."
    exit 1
fi

# Vérifier la version de Node.js
NODE_VERSION=$(node -v | cut -d 'v' -f 2 | cut -d '.' -f 1)
if [ "$NODE_VERSION" -lt 14 ]; then
    echo "La version de Node.js est trop ancienne. Veuillez installer Node.js v14 ou supérieur."
    exit 1
fi

# Installer les dépendances
echo "Installation des dépendances npm..."
npm install

# Créer les dossiers nécessaires s'ils n'existent pas
mkdir -p css js

# Compiler les assets pour la production
echo "Compilation des assets pour la production..."
npm run build

echo "Installation terminée avec succès!"
echo "Pour développer, utilisez 'npm run watch'"
echo "Pour compiler pour la production, utilisez 'npm run build'"
