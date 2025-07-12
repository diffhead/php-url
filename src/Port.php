<?php

namespace Diffhead\PHP\Url;

enum Port: int
{
    case Cassandra = 9042;
    case CouchDb = 5984;
    case ElasticSearch = 9200;
    case FileTransfer = 21;
    case FileTransferData = 20;
    case FileTransferOverSsh = 22;
    case FileTransferSecure = 990;
    case Imap = 143;
    case ImapSecure = 993;
    case MailTo = 25;
    case MongoDb = 27017;
    case MySql = 3306;
    case OracleDb = 1521;
    case Pop3 = 110;
    case Pop3Secure = 995;
    case PostgreSql = 5432;
    case RabbitMQ = 5672;
    case RabbitMQManagement = 15672;
    case Redis = 6379;
    case SqlServer = 1433;
    case Smtp = 587;
    case SmtpSecure = 465;
    case Web = 80;
    case WebSecure = 443;
}
