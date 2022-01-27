<?php

namespace Give\DonationForms\Routes;

/**
 * @since 2.18.0
 */
class DonationFormRoute
{
    /**
     * @return void
     */
    public function __invoke()
    {
        if ($this->isValidRequest()) {

            $post = get_post($_GET['id']);
            echo $post->post_name;
        }
    }

    /**
     * Check if the request is valid
     *
     * @return bool
     *
     */
    private function isValidRequest()
    {
        return isset($_GET['give-route'], $_GET['id']) && $_GET['give-route'] === 'forms';
    }
}
