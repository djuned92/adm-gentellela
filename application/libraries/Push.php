<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Push {
    // instancia do codeigniter
    public $ci;
    // key do servidor
    public $key = 'AIzaSyDPint96HMCXrfqJpDYEuSUYhgpgKGIqGc';
    // titulo
    public $title = '';
    // corpo
    public $body = '';
    
    /*
    *custom
    */
    public $lat = '';
    public $lng = '';
    public $notification_id = '';
    public $date = '';
    // end custom

    // imagem
    public $image = null;
    // url
    public $url = 'https://fcm.googleapis.com/fcm/send';
    // método construtor
    public function __construct() {
        // pega a instancia do ci
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

    /*
    * custom
    */
    // set a lat
    public function setLat( $lat ) {
        $this->lat = $lat;
        return $this;
    }

    public function setLng( $lng ) {
        $this->lng = $lng;
        return $this;
    }

    public function setNotificationId( $notification_id ) {
        $this->notification_id = $notification_id;
        return $this;
    }

    public function setDate( $date ) {
        $this->date = $date;
        return $this;
    }
    // end custom

    // set a image
    public function setImage( $image ) {
        $this->image = $image;
        return $this;
    }
    // dispara a notificacao
    public function fire( $idCelular = false ) {
        // seta o corpo
        $body = [
            "to" => ( $idCelular ) ? $idCelular : "/topics/all",
            "notification" => [	
                "title"             => $this->title, 
                "body"              => $this->body,
                "lat"               => $this->lat, 
                "lng"               => $this->lng, 
                "notification_id"   => $this->notification_id, 
                "date"              => $this->date, 
                "sound"             => "default", 
                "icon"              => "notify"
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
        // seta os headers
        $headers = [
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        ];
        // verifica se o curl esta instalado no servidor
        if ( function_exists( 'curl_init' ) ) {
            // envia o curl
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $this->url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            // pega o resultado
            $result = curl_exec ( $ch );
            curl_close ( $ch );
            return $result ;
        } else return false;
    }
}
/* end of file */