<?php

namespace SevenCoder\SecureShell;

class SSH
{
    private $connection;

    public function connect($host, $port)
    {
        $this->connection = ssh2_connect($host, $port);

        return $this->connection ? true : false;
    }

    public function authPassword($user, $pass): bool
    {
        return $this->connection ? ssh2_auth_password($this->connection, $user, $pass) : false;
    }

    public function authPublicKeyFile($user, $publicKey, $privateKey, $passphrase = null): bool
    {
        return $this->connection ? ssh2_auth_pubkey_file($this->connection, $user, $publicKey, $privateKey, $passphrase): false;
    }

    public function disconnect(): bool
    {
        if ($this->connection) {
            ssh2_disconnect($this->connection);
        }

        $this->connection = null;

        return true;
    }

    private function getOutput($stream, $id) {
        $streamOut = ssh2_fetch_stream($stream, $id);
        return stream_get_contents($streamOut);
    }

    public function exec($command, &$stdErr = null)
    {
        if(!$this->connection) {
            return null;
        }

        if (!$stream = ssh2_exec($this->connection, $command)) {
            return null;
        }

        stream_set_blocking($stream, true);

        $stdIo = $this->getOutput($stream, SSH2_STREAM_STDIO);

        $stdErr = $this->getOutput($stream, SSH2_STREAM_STDERR);

        stream_set_blocking($stream, false);

        return $stdIo;
    }
}
