<?php
class encryption {
    private $secret_key;
    private $cipher;

    public function __construct($secret_key) { // encryption key generated through Online AES key generator(128 byte)
        $this->secret_key = "ZygroG5ZGj5rANA8bn3PE5miz1/gec4haGGYZC4rESCd/hBAGMk2FeuOuswn+c   
        gbYMg9cpP7w/uf0JBiXcisUUVuvKrVKmV5atpJB8HEdBuXwruHzpKVLvwr6qp3sRI2GdMTxBsu4vaqjh9lOt
        C0lL7iMqCk9ic/Gsuw07uVCi9yr5LNZ1MNrh/Tbwfx0uHb"
        ;
        $this->cipher = 'AES-128-CBC';  
    }

    public function encrypt($email) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $encryptedEmail = openssl_encrypt($email, $this->cipher, $this->secret_key, 0, $iv);
        return base64_encode($encryptedEmail . '::' . $iv);
    }

    public function decrypt($encryptedEmail) {
        list($encrypted_data, $iv) = explode('::', base64_decode($encryptedEmail), 2);
        return openssl_decrypt($encrypted_data, $this->cipher, $this->secret_key, 0, $iv);
    }
}
?>
