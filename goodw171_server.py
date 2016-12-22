#!/usr/bin/env python3
# See https://docs.python.org/3.2/library/socket.html
# for a decscription of python socket and its parameters
import socket
import sys
import os
import string
import stat
from threading import Thread
from argparse import ArgumentParser
from flask import Flask,redirect

# for the server you may find the following python libraries useful:
#import os - check to see if a file exists in python -
# e.g., os.path.isfile, os.path.exists

#import stat
#check if a file has others permissions set, os.stat

#import sys - enables you to get the argument vector (argv) from command line and use
# values passed in from the command line


#other defintions that will come in handy for getting data and
#constructing a response
BUFSIZE = 4096
CRLF = '\r\n'

OK = 'HTTP/1.0 200 OK{}{}{}'.format(CRLF,CRLF,CRLF)
MOVED_PERMANENTLY = 'HTTP/1.0 301 Moved Permanently{}{}{}'.format(CRLF,CRLF,CRLF)
FORBIDDEN = 'HTTP/1.0 403 Forbidden{}{}{}'.format(CRLF,CRLF,CRLF)
NOT_FOUND = 'HTTP/1.0 404 Not Found{}{}{}'.format(CRLF,CRLF,CRLF)
METHOD_NOT_ALLOWED = 'HTTP/1.0 405 Method Not Allowed{}{}{}'.format(CRLF,CRLF,CRLF)
NOT_ACCEPTABLE = 'HTTP/1.0 406 Not Acceptable{}{}{}'.format(CRLF,CRLF,CRLF)

def client_talk(client_sock, client_addr):
    print('talking to {}'.format(client_addr))
    data = client_sock.recv(BUFSIZE)

    #String version
    req = data.decode('utf-8')

    #List version
    req2 = req.split('\n')
    
    #Request Type
    requestType = req2[0].split(" ")[0].strip()

    # host
    hostT = req2[1].split(":")[1].strip()
    
    #port number
    portNum = req2[1].split(":")[2].strip()

    #filename
    nameOfFile = req.split("/")[1].split(" ")[0]

    #Handle Moved Permanently (301)
    if nameOfFile == "csumn":
        print("csumn redirect")
        client_sock.send(bytes(MOVED_PERMANENTLY, 'utf-8'))
        return redirect("http://www.cs.umn.edu", code=301) 

    #Handle Post Method (405)
    if requestType == "POST":
        print("POST detected")
        client_sock.send(bytes(METHOD_NOT_ALLOWED, 'utf-8'))

    #Handle HEAD
    if requestType == "HEAD":
        print("In HEAD case")
        print("HTTP/1.1 200 OK")

    #Handle GET
    if requestType == "GET":
        print("In GET case")

        #Get files in directory
        filesInDir = os.listdir(".")

        #loop through files in directory
        for files in filesInDir:
            if files == nameOfFile:
                file = open(files, 'r')
                fileToSend = file.read()
                client_sock.send(bytes(OK, 'utf-8'))
                client_sock.send(bytes(fileToSend, 'utf-8'))
                file.close()
                break
        #Reached end of list - 404
        print("Not Found. Reached end of files search because http send not working correctly or file actually not found")
        client_sock.send(bytes(NOT_FOUND, 'utf-8'))
        

    # 406 detected
    else:
        print("Not Acceptable")
        client_sock.send(bytes(NOT_ACCEPTABLE, 'utf-8'))

    # clean up
    client_sock.shutdown(1)
    client_sock.close()
    print('connection closed.' + '\n')

class EchoServer:
  def __init__(self, host, port):
    print('listening on port {}'.format(port) + "\n")
    self.host = host
    self.port = port

    self.setup_socket()

    self.accept()

    self.sock.shutdown()
    self.sock.close()

  def setup_socket(self):
    self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    self.sock.bind((self.host, self.port))
    self.sock.listen(128)

  def accept(self):
    while True:
      (client, address) = self.sock.accept()
      th = Thread(target=client_talk, args=(client, address))
      th.start()

def parse_args():
    parser = ArgumentParser()
    parser.add_argument('--host', type=str, default='localhost',
                      help='specify a host to operate on (default: localhost)')
    parser.add_argument('-p', '--port', type=int, default=9001,
                      help='specify a port to operate on (default: 9001)')
    args = parser.parse_args()
    return (args.host, args.port)


if __name__ == '__main__':
    (host, port) = parse_args()
    EchoServer(host, port)

