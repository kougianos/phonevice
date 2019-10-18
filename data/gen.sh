#!/bin/bash

echo "[GEN: Start]"

cd ../js
SPWD=`pwd`

# jQuery
echo "[GEN: jQuery]"
cp $SPWD/jquery.min.js custom.min.js

# jQuery UI
echo "[GEN: jQuery UI]"
cat $SPWD/jquery-ui.min.js >> custom.min.js

# Bootstrap
echo "[GEN: Bootstrap]"
cat $SPWD/bootstrap.bundle.min.js >> custom.min.js

# Chart JS
echo "[GEN: Chart JS]"
cat $SPWD/chart.min.js >> custom.min.js

# Custom JS
echo "[GEN: Custom]"
cp $SPWD/custom.js tmp.js
perl -i -pe 'BEGIN{undef $/;} s/\/\*[ \!\n\#](.*?)\*\// /smgi' tmp.js
java -jar ../data/yuicompressor/yuicompressor-2.4.8.jar --type js -o custom1.min.js tmp.js
rm -rf tmp.js
cat $SPWD/custom1.min.js >> custom.min.js
rm -rf custom1.min.js

# Clean comments
echo "[GEN: Clean comments]"
perl -i -pe 'BEGIN{undef $/;} s/\/\*[ \!\n\#](.*?)\*\// /smgi' custom.min.js

# GZIP pre-compress files
gzip -f -k -9 custom.min.js

# CSS
echo "[GEN: CSS]"
cd ../css/
SPWD=`pwd`

# Bootstrap
echo "[GEN: Bootstrap]"
cp $SPWD/bootstrap.min.css style.min.css

# jQuery UI
echo "[GEN: jQuery UI]"
cat $SPWD/jquery-ui.min.css >> style.min.css

# Style
echo "[GEN: Style]"
cp $SPWD/style.css tmp.css
perl -i -pe 'BEGIN{undef $/;} s/\/\*[ \!\n\#](.*?)\*\// /smgi' tmp.css
java -jar ../data/yuicompressor/yuicompressor-2.4.8.jar --type css -o style1.min.css tmp.css
rm -rf tmp.css
cat $SPWD/style1.min.css >> style.min.css
rm -rf style1.min.css

# GZIP pre-compress files
gzip -f -k -9 style.min.css

echo "COMPLETE!!"