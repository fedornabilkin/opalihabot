#!/usr/bin/env bash
echo "deb http://us-west-2.ec2.archive.ubuntu.com/ubuntu/ trusty multiverse
deb http://us-west-2.ec2.archive.ubuntu.com/ubuntu/ trusty-updates multiverse
deb http://us-west-2.ec2.archive.ubuntu.com/ubuntu/ trusty-backports main restricted universe multiverse" | sudo tee /etc/apt/sources.list.d/multiverse.list