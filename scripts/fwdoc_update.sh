#!/bin/sh

if [ $# -lt 2 ]
then
echo "Usage: $0 URL CONFIG_FILE"
exit 1
fi

CONFIG=$2
URL=$1
BASENAME=`basename $0`
WORK_DIR=`echo $0 | awk -F $BASENAME {'print $1'}`
#`which curl` -s -F file=@$2 $1 -o /dev/null
#`which curl` -s -F file=@$2 $1 -o ../htdocs/out.html
`which curl` -s -F file=@$2 $1
