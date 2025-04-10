#!/bin/sh
# This script contains a collection of useful aliases for development tasks.

alias vitebuild="npm run build && php artisan view:clear && php artisan config:clear && echo '🎉 Build terminé, prêt pour mobile !'"
