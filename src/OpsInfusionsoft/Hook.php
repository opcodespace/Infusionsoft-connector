<?php


namespace OpsInfusionsoft;

use OpsInfusionsoft\OpsInfusionsoft;
class Hook
{
    public static function init()
    {
        $self = new self;
        add_action( 'authorization_buttons', array( $self, 'authorization_button' ), 10 );
        add_action( 'authorization_buttons', array( $self, 'get_token' ), 9 );
    }

    public function authorization_button()
    {
        $OpsInfusionsoft = new OpsInfusionsoft();
        $url = $OpsInfusionsoft->getAuthorizationUrl();
        echo "<a href='{$url}'>Authorize Infusionsoft</a>";
    }

    public function get_token()
    {
        if(isset($_GET['code']) && $_GET['vendor'] === 'infusionsoft'){
            $OpsInfusionsoft = new OpsInfusionsoft();
            $OpsInfusionsoft->getToken($_GET['code']);

            echo "<div class='success-message'>Successfully Authorized.</div>";
        }
    }
}


add_action('plugins_loaded', array('\OpsInfusionsoft\Hook', 'init'));