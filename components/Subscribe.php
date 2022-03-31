<?php namespace VojtaSvoboda\Ecomail\Components;

use ApplicationException;
use Cms\Classes\ComponentBase;
use Ecomail;
use Request;
use ValidationException;
use Validator;
use VojtaSvoboda\Ecomail\Models\Settings;

class Subscribe extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Ecomail subscribe',
            'description' => 'Ecomail subscribe form',
        ];
    }

    public function defineProperties()
    {
        return [
            'list' => [
                'title' => 'Ecomail list ID',
                'description' => 'In Ecomail > Contacts open requested List and use numeric ID in URL, probably something like 1.',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Ecomail list ID has to be numeric',
            ],
            'confirm' => [
                'title' => 'Double Opt-in',
                'description' => 'Enable confirmation to Ecomail list subscription.',
                'type' => 'checkbox',
                'default' => true,
            ],
            'resubscribe' => [
                'title' => 'Resubscribe',
                'description' => 'Force resubscribe in case of unsubscribed status.',
                'type' => 'checkbox',
                'default' => false,
            ],
        ];
    }

    public function onSignup()
    {
        // prepare API key
        $api_key = Settings::get('api_key');
        if (empty($api_key)) {
            throw new ApplicationException('Ecomail API key is not configured.');
        }

        // fetch input
        $data = Request::post();

        // validate input
        $validation = Validator::make($data, [
            'email' => 'required|email|min:2|max:64',
        ]);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        // add new subscriber
        $ecomail = new Ecomail($api_key);
        $this->page['error'] = null;
        $subscriptionData = [
            'subscriber_data' => [
                'email' => $data['email'],
            ],
            'skip_confirmation' => !$this->property('confirm'),
            'resubscribe' => $this->property('resubscribe'),
        ];

        $result = $ecomail->addSubscriber($this->property('list'), $subscriptionData);

        if (is_array($result) === false) {
            $this->page['error'] = 'Something went wrong, try it again later.';
        }

        if (isset($result['already_subscribed']) && !empty($result['already_subscribed'])) {
            $this->page['error'] = 'Already subscribed.';
        }
    }
}
