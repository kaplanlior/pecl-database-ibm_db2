# bash ftpcompile.sh ut28p63 adc
MYPWD=$(<$HOME/.ftprc)
ftp -i -n -v $1 << ftp_end
user $2 $MYPWD

quote namefmt 1
bin

cd /QOpenSys/zend7/home/zend7/ibm_db2-1.9.9/tests
mput *

quit

ftp_end

