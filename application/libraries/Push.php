<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Push {
    public $ci;
    // key firebase
    public $key = '';
    // tilte
    public $title = '';
    // body
    public $body = '';
    
    // image
    public $image = null;
    // url
    public $url = 'https://fcm.googleapis.com/fcm/send';
    
    public function __construct() {
        $this->ci =& get_instance();
    }
    // set a title
    public function setTitle( $title ) {
        $this->title = $title;
        return $this;
    }
    // set a body
    public function setBody( $body ) {
        $this->body = $body;
        return $this;
    }
    // set a image
    public function setImage( $image ) {
        $this->image = $image;
        return $this;
    }
    // push notification
    public function fire( $idCelular = false ) {
        // seta o corpo
        $body = [
            "to" => ( $idCelular ) ? $idCelular : "/topics/all",
            "notification" => [	
                "title"             => $this->title, 
                "body"              => $this->body,
            ],
            "data" => [
                "message" => $this->body
            ]
        ];
        // verifica se existe uma imagem
        if ( $this->image ) {
            $body['notification']['image'] = $this->image;
        }
        $fields = json_encode( $body );
        // set a headers
        $headers = [
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        ];
        
        if ( function_exists( 'curl_init' ) ) {
            // setting curl
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $this->url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            // exec curl
            $result = curl_exec ( $ch );
            curl_close ( $ch );
            return $result ;
        } else return false;
    }
}
/* End of file Push.php */
/* Location: ./application/libraries/Push.php */