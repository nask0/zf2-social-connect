<?php
namespace SocialConnect\Service;

use SocialConnect\Config\FacebookConfig;

/** @TODO */
use Facebook;

use Zend\Http\Request;

class FacebookService implements Provider
{
    const PERMISSION_ABOUT_ME = 'user_about_me';
    const PERMISSION_ACTIVITIES = 'user_activities';
    const PERMISSION_BIRTHDAY = 'user_birthday';
    const PERMISSION_CHECKINS = 'user_checkins';
    const PERMISSION_EDUCATION = 'user_education_history';
    const PERMISSION_EVENTS = 'user_events';
    const PERMISSION_HOMETOWN = 'user_hometown';
    const PERMISSION_INTERESTS = 'user_interests';
    const PERMISSION_LIKES  = 'user_likes';
    const PERMISSION_LOCATION = 'user_location';
    const PERMISSION_NOTES = 'user_notes';
    const PERMISSION_PHOTOS = 'user_photos';
    const PERMISSION_QUESTIONS     		  = 'user_questions';
    const PERMISSION_RELATIONSHIPS        = 'user_relationships';
    const PERMISSION_RELATIONSHIP_DETAILS = 'user_relationship_details';
    const PERMISSION_RELIGION_POLITICS 	  = 'user_religion_politics';
    const PERMISSION_STATUS 			  = 'user_status';
    const PERMISSION_SUBSCRIPTIONS 		  = 'user_subscriptions';
    const PERMISSION_VIDEOS 			  = 'user_videos';
    const PERMISSION_WEBSITE 			  = 'user_website';
    const PERMISSION_WORK_HISTORY 		  = 'user_work_history';
    const PERMISSION_EMAIL    			  = 'email';

    const FRIENDS_PERMISSION_ABOUT_ME   		  = 'friends_about_me';
    const FRIENDS_PERMISSION_ACTIVITIES 		  = 'friends_activities';
    const FRIENDS_PERMISSION_BIRTHDAY   		  = 'friends_birthday';
    const FRIENDS_PERMISSION_CHECKINS   		  = 'friends_checkins';
    const FRIENDS_PERMISSION_EDUCATION  		  = 'friends_education_history';
    const FRIENDS_PERMISSION_EVENTS     		  = 'friends_events';
    const FRIENDS_PERMISSION_HOMETOWN   		  = 'friends_hometown';
    const FRIENDS_PERMISSION_INTERESTS  		  = 'friends_interests';
    const FRIENDS_PERMISSION_LIKES      		  = 'friends_likes';
    const FRIENDS_PERMISSION_LOCATION   		  = 'friends_location';
    const FRIENDS_PERMISSION_NOTES      		  = 'friends_notes';
    const FRIENDS_PERMISSION_PHOTOS               = 'friends_photos';
    const FRIENDS_PERMISSION_QUESTIONS     		  = 'friends_questions';
    const FRIENDS_PERMISSION_RELATIONSHIPS        = 'friends_relationships';
    const FRIENDS_PERMISSION_RELATIONSHIP_DETAILS = 'friends_relationship_details';
    const FRIENDS_PERMISSION_RELIGION_POLITICS 	  = 'friends_religion_politics';
    const FRIENDS_PERMISSION_STATUS 			  = 'friends_status';
    const FRIENDS_PERMISSION_SUBSCRIPTIONS 		  = 'friends_subscriptions';
    const FRIENDS_PERMISSION_VIDEOS 			  = 'friends_videos';
    const FRIENDS_PERMISSION_WEBSITE 			  = 'friends_website';
    const FRIENDS_PERMISSION_WORK_HISTORY 		  = 'friends_work_history';

    const EXTENDED_PERMISSION_READ_FRIENDS_LISTS 	  = 'read_friendlists';
    const EXTENDED_PERMISSION_READ_INSIGHTS      	  = 'read_insights';
    const EXTENDED_PERMISSION_READ_MAILBOX       	  = 'read_mailbox';
    const EXTENDED_PERMISSION_READ_REQUESTS      	  = 'read_requests';
    const EXTENDED_PERMISSION_READ_STREAM        	  = 'read_stream';
    const EXTENDED_PERMISSION_XMPP_LOGIN         	  = 'xmpp_login';
    const EXTENDED_PERMISSION_ADS_MANAGEMENT     	  = 'ads_management';
    const EXTENDED_PERMISSION_CREATE_EVENT       	  = 'create_event';
    const EXTENDED_PERMISSION_MANAGE_FRIENDLISTS      = 'manage_friendlists';
    const EXTENDED_PERMISSION_MANAGE_NOTIFICATIONS    = 'manage_notifications';
    const EXTENDED_PERMISSION_USER_ONLINE_PRESENCE    = 'user_online_presence';
    const EXTENDED_PERMISSION_FRIENDS_ONLINE_PRESENCE = 'friends_online_presence';
    const EXTENDED_PERMISSION_PUBLISH_CHECKINS 	 	  = 'publish_checkins';
    const EXTENDED_PERMISSION_PUBLISH_STREAM 	 	  = 'publish_stream';
    const EXTENDED_PERMISSION_RSVP_EVENT 	 		  = 'rsvp_event';
    const EXTENDED_PERMISSION_MANAGE_PAGES 	 		  = 'manage_pages';

    /**
     * @var array
     */
    private $allowedPermissions = array(
        self::PERMISSION_ABOUT_ME,
        self::PERMISSION_ACTIVITIES,
        self::PERMISSION_BIRTHDAY,
        self::PERMISSION_CHECKINS,
        self::PERMISSION_EDUCATION,
        self::PERMISSION_EMAIL,
        self::PERMISSION_EVENTS,
        self::PERMISSION_HOMETOWN,
        self::PERMISSION_INTERESTS,
        self::PERMISSION_LIKES,
        self::PERMISSION_LOCATION,
        self::PERMISSION_NOTES,
        self::PERMISSION_PHOTOS,
        self::PERMISSION_QUESTIONS,
        self::PERMISSION_RELATIONSHIP_DETAILS,
        self::PERMISSION_RELATIONSHIPS,
        self::PERMISSION_RELIGION_POLITICS,
        self::PERMISSION_STATUS,
        self::PERMISSION_SUBSCRIPTIONS,
        self::PERMISSION_VIDEOS,
        self::PERMISSION_WEBSITE,
        self::PERMISSION_WORK_HISTORY,
        self::FRIENDS_PERMISSION_ABOUT_ME,
        self::FRIENDS_PERMISSION_ACTIVITIES,
        self::FRIENDS_PERMISSION_BIRTHDAY,
        self::FRIENDS_PERMISSION_CHECKINS,
        self::FRIENDS_PERMISSION_EDUCATION,
        self::FRIENDS_PERMISSION_EVENTS,
        self::FRIENDS_PERMISSION_HOMETOWN,
        self::FRIENDS_PERMISSION_INTERESTS,
        self::FRIENDS_PERMISSION_LIKES,
        self::FRIENDS_PERMISSION_LOCATION,
        self::FRIENDS_PERMISSION_NOTES,
        self::FRIENDS_PERMISSION_PHOTOS,
        self::FRIENDS_PERMISSION_QUESTIONS,
        self::FRIENDS_PERMISSION_RELATIONSHIP_DETAILS,
        self::FRIENDS_PERMISSION_RELATIONSHIPS,
        self::FRIENDS_PERMISSION_RELIGION_POLITICS,
        self::FRIENDS_PERMISSION_STATUS,
        self::FRIENDS_PERMISSION_SUBSCRIPTIONS,
        self::FRIENDS_PERMISSION_VIDEOS,
        self::FRIENDS_PERMISSION_WEBSITE,
        self::FRIENDS_PERMISSION_WORK_HISTORY,
        self::EXTENDED_PERMISSION_ADS_MANAGEMENT,
        self::EXTENDED_PERMISSION_CREATE_EVENT,
        self::EXTENDED_PERMISSION_FRIENDS_ONLINE_PRESENCE,
        self::EXTENDED_PERMISSION_MANAGE_FRIENDLISTS,
        self::EXTENDED_PERMISSION_MANAGE_NOTIFICATIONS,
        self::EXTENDED_PERMISSION_PUBLISH_CHECKINS,
        self::EXTENDED_PERMISSION_PUBLISH_STREAM,
        self::EXTENDED_PERMISSION_READ_FRIENDS_LISTS,
        self::EXTENDED_PERMISSION_READ_INSIGHTS,
        self::EXTENDED_PERMISSION_READ_MAILBOX,
        self::EXTENDED_PERMISSION_READ_REQUESTS,
        self::EXTENDED_PERMISSION_READ_STREAM,
        self::EXTENDED_PERMISSION_RSVP_EVENT,
        self::EXTENDED_PERMISSION_USER_ONLINE_PRESENCE,
        self::EXTENDED_PERMISSION_XMPP_LOGIN,
        self::EXTENDED_PERMISSION_MANAGE_PAGES,
    );

    /**
     * @var Facebook
     */
    protected $provider;

    /**
     * @var FacebookConfig;
     */
    private $config;

    /**
     * @var string
     */
    private $applicationSecret;

    /**
     * @var string
     */
    private $applicationId;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var array
     */
    private $permissions = array();

    /**
     * @var boolean
     */
    private $needsExtendedToken = false;

    /**
     * @var array
     */
    private $returnUrlData = array();

    /**
     * @var string
     */
    private $shouldDisplayInPopup = 'page';

    /**
     * @var bool
     */
    private $isValid = false;

    /**
     * @param FacebookConfig $config
     */
    public function __construct(FacebookConfig $config, Request $request)
    {
        $error = $request->getQuery('error');

        if (!empty($error)) {
            $this->isValid = false;
            return;
        }

        if (!$config->isEnabled()) {
            throw new \Exception('Facebook is not enabled');
        }

        $this->applicationId = $config->getPublicKey();
        $this->applicationSecret = $config->getSecretKey();
        $this->needsExtendedToken = $config->needsExtendedToken();
        $this->returnUrlData = $config->getReturnUrlData();
        $this->shouldDisplayInPopup = $config->shouldDisplayInPopup() ? 'popup' : 'page';

        foreach ($config->getPermissions() as $perm) {
            if (!in_array($perm, $this->allowedPermissions)) {
                throw new \Exception(sprintf('%s is not a valid Facebook permission', $perm));
            }

            $this->permissions[] = $perm;
        }
    }

    /**
     * @return array
     */
    public function getReturnUrlData()
    {
        return $this->returnUrlData;
    }

    /**
     * @param string $returnUrl
     *
     * @return string
     */
    public function getLoginUrl($returnUrl)
    {
        if (!$this->provider) {
            $this->provider = new Facebook(array(
                'appId'  => $this->applicationId,
                'secret' => $this->applicationSecret
            ));
        }

        return $this->provider->getLoginUrl(array(
            'redirect_uri' => $returnUrl,
            'scope'        => implode(',', $this->permissions),
            'display'      => $this->shouldDisplayInPopup
        ));
    }

    /**
     * @return bool|NormalizedData
     */
    public function getUserData()
    {
        if (!$this->provider) {
            $this->provider = new Facebook(array(
                'appId'  => $this->applicationId,
                'secret' => $this->applicationSecret
            ));
        }

        $user = $this->provider->getUser();

        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                return new NormalizedData(NormalizedData::PROVIDER_TYPE_FACEBOOK, $this->provider->api('/me'));
            } catch (FacebookApiException $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !(bool) $this->isValid;
    }
}