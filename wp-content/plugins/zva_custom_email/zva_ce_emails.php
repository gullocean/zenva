<?php
    
    require_once( plugin_dir_path(__FILE__) . 'zva_ce_emogrifier.php' );

    Class ZvaWpMail {
        protected $template_html;

        public function __construct() {
            $this->template_html  = 'emails/email-body.php';
        }

        public function get_content_html($heading, $email, $content) {
            return $this->wc_get_template_html( $this->template_html, array(
                'email_heading' => $heading,
                'email'         => $email,
                'content'       => $content,
            ) );
        }

        function wc_get_template_html( $template_name, $args = array() ) {
            ob_start();
            wc_get_template( $template_name, $args );
            return ob_get_clean();
        }

        public function style_inline( $content ) {
            // make sure we only inline CSS for html emails
            ob_start();
            wc_get_template( 'emails/email-styles.php' );
            $css = apply_filters( 'woocommerce_email_styles', ob_get_clean() );

            // apply CSS styles inline for picky email clients
            try {
                $emogrifier = new Emogrifier( $content, $css );
                $content    = $emogrifier->emogrify();
            } catch ( Exception $e ) {
                $logger = wc_get_logger();
                $logger->error( $e->getMessage(), array( 'source' => 'emogrifier' ) );
            }

            return $content;
        }

        public function zva_wp_send_mail( $sendTo, $subject, $heading_title, $message, $headers = '', $attachments = array() ) {

            global $woocommerce;
            $mailer = $woocommerce->mailer();

            // Send Email Template defined by zenva plugin.
            $body = $this->get_content_html($heading_title, $sendTo, $message);

            $message = apply_filters( 'woocommerce_mail_content', $this->style_inline( $body ) );

            $return = $mailer->send( $sendTo, $subject, $message);

            return $return;
        }
    }

?>
