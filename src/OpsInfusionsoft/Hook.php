<?php


namespace OpsInfusionsoft;

use OpsInfusionsoft\OpsInfusionsoft;

class Hook
{
    protected $OpsInfusionsoft;
    public function __construct()
    {
        $this->OpsInfusionsoft = new OpsInfusionsoft(IS_CLIENT_ID, IS_SECRET_ID, IS_REDIRECT_URI);
    }

    public static function init()
    {
        $self = new self;
        add_action( 'authorization_buttons', array( $self, 'authorization_button' ), 10 );
        add_action( 'authorization_buttons', array( $self, 'get_token' ), 9 );
        add_action( 'admin_post_infusionsoft_authorization',array( $self, 'infusionsoft_authorization' ));
    }

    public function infusionsoft_authorization()
    {
        if(isset($_GET['code'])) {
            $this->OpsInfusionsoft->getToken($_GET['code']);
            wp_redirect(admin_url('/options-general.php?page=auth-apps&vendor=infusionsoft'));
            exit;
        }

        die("No authorized code");
    }

    public function authorization_button()
    {
        $url = $this->OpsInfusionsoft->getAuthorizationUrl();
        echo "<a href='{$url}' class='button button-primary'>Authorize Infusionsoft</a>";
    }

    public function get_token()
    {
        if(isset($_GET['vendor']) && $_GET['vendor'] === 'infusionsoft'){
            echo "<div class='updated notice'><p>Successfully Authorized.</p></div>";
        }
    }
}