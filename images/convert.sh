#!/bin/sh

OUTPUT=./new/
find -maxdepth 1 -type f -not -iname "*.sh" | while read image; do
	basenamed=$(basename $image)
	base="${basenamed%.*}"
	jpgImage=$OUTPUT/${base::6}.jpg
	echo $jpgImage
	
	convert "$image" -background white -resize 300x300 -gravity center -extent 300x300 "$jpgImage"
done