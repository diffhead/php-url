<?php

namespace Diffhead\PHP\Url;

enum Scheme: string
{
    case File = 'file';
    case FileTransfer = 'ftp';
    case FileTransferOverSsh = 'sftp';
    case FileTransferSecure = 'ftps';
    case Http = 'http';
    case Https = 'https';
    case Imap = 'imap';
    case MailTo = 'mailto';
    case Pop3 = 'pop3';
    case SecureCopy = 'scp';
    case Smtp = 'smtp';
    case WebSocket = 'ws';
    case WebSocketSecure = 'wss';
}
