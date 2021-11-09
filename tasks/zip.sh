#!/bin/sh

# ----------------------------------------------------
# Zip
# ----------------------------------------------------

# Variables

PACKAGE_NAME=$(node -p -e "require('./package.json').name")

# Copy

cpx "./plugin.php" "./dist/$PACKAGE_NAME"

# Compress

cd ./dist && bestzip "$PACKAGE_NAME.zip" $PACKAGE_NAME