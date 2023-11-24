# script to scan network for devices and alert user via Pushbullet service

import platform    # For getting the operating system name
import subprocess  # For executing a shell command
import os
import threading

from pushbullet import Pushbullet
from time import sleep

pb = Pushbullet("$API_KEY")
dev = pb.get_device('$DEVICE_NAME')

network_dev = {"$DEVICE_1" : "$DEVICE_2", "$DEVICE_3" : "$DEVICE_n"}
dev_toggle = [0] * len(network_dev)


def ping(host):
    """
    Returns True if host (str) responds to a ping request.
    Remember that a host may not respond to a ping (ICMP) request even if the host name is valid.
    """

    # Option for the number of packets as a function of
    param = '-n' if platform.system().lower()=='windows' else '-c'

    # Building the command. Ex: "ping -c 1 google.com"
    command = ['ping', param, '1', host]

    with open(os.devnull, 'w') as shutup:
       return_code = subprocess.call(command, stdout=shutup, stderr=shutup)

    return return_code == 0


def mainfunc():
	global dev_toggle
	counter = 0
	threading.Timer(5.0, mainfunc).start() #run mainfunc every 5 seconds

	for x in network_dev:

		if (ping(x)):
			if(not dev_toggle[counter]):
				push = dev.push_note("Network",network_dev[x] + " connected")
				dev_toggle[counter] = 1
		else:
			if(dev_toggle[counter]):
				push = dev.push_note("Network",network_dev[x] + " disconnected")
				dev_toggle[counter] = 0
		counter+=1

push = dev.push_note("Application", "Script started")
mainfunc()

