# shellcheck disable=SC1113
#/!bin/bash

cat << "EOF"
Copyright (c) 2022 Ricardo Cimma
rcimma04@gmail.com

EOF

cp -r /root/.ssh_external/ /root/.ssh
chmod -R 700 /root/.ssh

apache2-foreground
