<?php

namespace InstagramScraper\Model;

use InstagramScraper\Endpoints;

/**
 * Class Media
 * @package InstagramScraper\Model
 */
class Media extends AbstractModel
{
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_SIDECAR = 'sidecar';
    const TYPE_CAROUSEL = 'carousel';

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $shortCode = '';

    /**
     * @var int
     */
    protected $createdTime = 0;

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $imageLowResolutionUrl = '';

    /**
     * @var string
     */
    protected $imageThumbnailUrl = '';

    /**
     * @var string
     */
    protected $imageStandardResolutionUrl = '';

    /**
     * @var string
     */
    protected $imageHighResolutionUrl = '';

    /**
     * @var array
     */
    protected $squareImages = [];

    /**
     * @var array
     */
    protected $carouselMedia = [];

    /**
     * @var string
     */
    protected $caption = '';

    /**
     * @var bool
     */
    protected $isCaptionEdited = false;

    /**
     * @var bool
     */
    protected $isAd = false;

    /**
     * @var string
     */
    protected $videoLowResolutionUrl = '';

    /**
     * @var string
     */
    protected $videoStandardResolutionUrl = '';

    /**
     * @var integer
     */
    protected $videoDuration = '';

    /**
     * @var string
     */
    protected $videoLowBandwidthUrl = '';

    /**
     * @var int
     */
    protected $videoViews = 0;

    /**
     * @var Account
     */
    protected $owner;

    /**
     * @var int
     */
    protected $ownerId = 0;

    /**
     * @var int
     */
    protected $likesCount = 0;

    /**
     * @var boolean
     */
    protected $hasLiked = null;

    /**
     * @var
     */
    protected $locationId;

    /**
     * @var string
     */
    protected $locationName = '';

    /**
     * @var bool
     */
    protected $commentsDisabled = false;

    /**
     * @var string
     */
    protected $commentsCount = 0;

    /**
     * @var Comment[]
     */
    protected $comments = [];

    /**
     * @var Comment[]
     */
    protected $previewComments = [];

    /**
     * @var bool
     */
    protected $hasMoreComments = false;

    /**
     * @var string
     */
    protected $commentsNextPage = '';

    /**
     * @var Media[]|array
     */
    protected $sidecarMedias = [];

    /**
     * @var string
     */
    protected $locationSlug;

    /**
     * @var string
     */
    protected $altText;

    /**
     * @var string
     */
    protected $locationAddressJson;
    /**
     * @var array
     */
    protected $taggedUsers=[];
    /**
     * @var array
     */
    protected $taggedUsersIds=[];

    /**
     * @param string $code
     *
     * @return int
     */
    public static function getIdFromCode($code)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $id = 0;
        for ($i = 0; $i < strlen($code); $i++) {
            $c = $code[$i];
            $id = $id * 64 + strpos($alphabet, $c);
        }
        return $id;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public static function getLinkFromId($id)
    {
        $code = Media::getCodeFromId($id);
        return Endpoints::getMediaPageLink($code);
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public static function getCodeFromId($id)
    {
        $parts = explode('_', $id);
        $id = $parts[0];
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $code = '';
        while ($id > 0) {
            $remainder = $id % 64;
            $id = ($id - $remainder) / 64;
            $code = $alphabet[$remainder] . $code;
        }
        return $code;
    }

    /**
     * @return array
     */
    public function getTaggedUsers(): array
    {
        return $this->taggedUsers;
    }

    /**
     * @return array
     */
    public function getTaggedUsersIds(): array
    {
        return $this->taggedUsersIds;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * @return int
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getImageLowResolutionUrl()
    {
        return $this->imageLowResolutionUrl;
    }

    /**
     * @return string
     */
    public function getImageThumbnailUrl()
    {
        return $this->imageThumbnailUrl;
    }

    /**
     * @return string
     */
    public function getImageStandardResolutionUrl()
    {
        return $this->imageStandardResolutionUrl;
    }

    /**
     * @return string
     */
    public function getImageHighResolutionUrl()
    {
        return $this->imageHighResolutionUrl;
    }


    /**
     * @return array
     */
    public function getSquareImages()
    {
        return $this->squareImages;
    }


    /**
     * @return array
     */
    public function getCarouselMedia()
    {
        return $this->carouselMedia;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function isCaptionEdited()
    {
        return $this->isCaptionEdited;
    }

    /**
     * @return bool
     */
    public function isAd()
    {
        return $this->isAd;
    }

    /**
     * @return string
     */
    public function getVideoLowResolutionUrl()
    {
        return $this->videoLowResolutionUrl;
    }

    /**
     * @return string
     */
    public function getVideoStandardResolutionUrl()
    {
        return $this->videoStandardResolutionUrl;
    }

    /**
     * @return integer
     */
    public function getVideoDuration()
    {
        return $this->videoDuration;
    }

    /**
     * @return string
     */
    public function getVideoLowBandwidthUrl()
    {
        return $this->videoLowBandwidthUrl;
    }

    /**
     * @return int
     */
    public function getVideoViews()
    {
        return $this->videoViews;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @return int
     */
    public function getLikesCount()
    {
        return $this->likesCount;
    }

    /**
     * @return boolean
     */
    public function getHasLiked()
    {
        return $this->hasLiked;
    }

    /**
     * @return mixed
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @param string
     */
    public function setLocationName($name)
    {
        $this->locationName = $name;
    }

    /**
     * @return bool
     */
    public function getCommentsDisabled()
    {
        return $this->commentsDisabled;
    }

    /**
     * @return string
     */
    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return Comment[]
     */
    public function getPreviewComments()
    {
        return $this->previewComments;
    }

    /**
     * @return bool
     */
    public function hasMoreComments()
    {
        return $this->hasMoreComments;
    }

    /**
     * @return string
     */
    public function getCommentsNextPage()
    {
        return $this->commentsNextPage;
    }

    /**
     * @return Media[]|array
     */
    public function getSidecarMedias()
    {
        return $this->sidecarMedias;
    }

    /**
     * @return string
     */
    public function getLocationSlug()
    {
        return $this->locationSlug;
    }

    /**
     * @param string
     */
    public function setLocationSlug($slug)
    {
        $this->locationSlug = $slug;
    }

    /**
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * @return string
     */
    public function getLocationAddressJson()
    {
        return $this->locationAddressJson;
    }

    /**
     * @return mixed
     */
    public function getLocationAddress()
    {
        return json_decode($this->locationAddressJson);
    }

    /**
     * @param $value
     * @param $prop
     */
    protected function initPropertiesCustom($value, $prop, $arr)
    {
        switch ($prop) {
            case 'id':
                $this->id = $value;
                break;
            case 'media_type':
                switch ($value) {
                    case 1:
                        $this->type = static::TYPE_IMAGE;
                        break;
                    case 2:
                        $this->type = static::TYPE_VIDEO;
                        break;
                }
                break;
            case 'date':
            case 'created_time':
                $this->createdTime = (int)$value;
                break;
            case 'code':
            case 'shortcode':
                $this->shortCode = $value;
                $this->link = Endpoints::getMediaPageLink($this->shortCode);
                break;
            case 'link':
                $this->link = $value;
                break;
            case 'comments_disabled':
                $this->commentsDisabled = $value;
                break;
            case 'comment_count':
                $this->commentsCount = $arr[$prop];
                break;
            case 'edge_liked_by':
            case 'edge_media_preview_like':
            case 'like_count':
                $this->likesCount = $arr[$prop];
                break;
            case 'image_versions2':
                foreach ($value['candidates'] as $media) {
                    // $mediasUrl[] = $media['src'];
                    switch ($media['width']) {
                        case 640:
                            $this->imageThumbnailUrl = $media['url'];
                            break;
                        case 750:
                            $this->imageLowResolutionUrl = $media['url'];
                            break;
                        case 1080:
                            $this->imageStandardResolutionUrl = $media['url'];
                            break;
                    }
                }
                break;
            case 'thumbnail_resources':
                $squareImagesUrl = [];
                foreach ($value as $squareImage) {
                    $squareImagesUrl[] = $squareImage['src'];
                }
                $this->squareImages = $squareImagesUrl;
                break;
            case 'display_url':
                $this->imageHighResolutionUrl = $value;
                break;
            case 'display_src':
                $this->imageHighResolutionUrl = $value;
                if (!isset($this->type)) {
                    $this->type = static::TYPE_IMAGE;
                }
                break;
            case 'thumbnail_src':
                $this->imageThumbnailUrl = $value;
                break;
            case 'carousel_media':
                $this->type = self::TYPE_CAROUSEL;
                $this->carouselMedia = [];
                foreach ($arr["carousel_media"] as $carouselArray) {
                    self::setCarouselMedia($arr, $carouselArray, $this);
                }
                break;
            case 'caption':
                $this->caption = $arr[$prop]['text'];
                break;
            case 'accessibility_caption':
                $this->altText = $value;
                break;
            case 'video_views':
                $this->videoViews = $value;
                $this->type = static::TYPE_VIDEO;
                break;
            case 'videos':
                $this->videoLowResolutionUrl = $arr[$prop]['low_resolution']['url'];
                $this->videoStandardResolutionUrl = $arr[$prop]['standard_resolution']['url'];
                $this->videoLowBandwidthUrl = $arr[$prop]['low_bandwidth']['url'];
                break;
            case 'video_duration':
                $this->videoDuration = $arr[$prop];
                break;
            case 'video_resources':
                foreach ($value as $video) {
                    if ($video['profile'] == 'MAIN') {
                        $this->videoStandardResolutionUrl = $video['src'];
                    } elseif ($video['profile'] == 'BASELINE') {
                        $this->videoLowResolutionUrl = $video['src'];
                        $this->videoLowBandwidthUrl = $video['src'];
                    }
                }
                break;
            case 'location':
                if(isset($arr[$prop])) {
                    $this->locationId = isset($arr[$prop]['id']) ? $arr[$prop]['id'] : null;
                    $this->locationName = isset($arr[$prop]['name']) ? $arr[$prop]['name'] : null;
                    $this->locationSlug = isset($arr[$prop]['slug']) ? $arr[$prop]['slug'] : null;
                    $this->locationAddressJson = isset($arr[$prop]['address_json']) ? $arr[$prop]['address_json'] : null;
                }
                break;
            case 'owner':
            case 'user':
                $this->owner = Account::create($arr[$prop]);
                break;
            case 'is_video':
                if ((bool)$value) {
                    $this->type = static::TYPE_VIDEO;
                }
                break;
            case 'video_url':
                $this->videoStandardResolutionUrl = $value;
                break;
            case 'video_view_count':
                $this->videoViews = $value;
                break;
            case 'caption_is_edited':
                $this->isCaptionEdited = $value;
                break;
            case 'is_ad':
                $this->isAd = $value;
                break;
            case 'taken_at_timestamp':
                $this->createdTime = $value;
                break;

            case 'edge_media_preview_comment':
                if (isset($arr[$prop]['count'])) {
                    $this->commentsCount = (int)$arr[$prop]['count'];
                }
                if (isset($arr[$prop]['edges']) && is_array($arr[$prop]['edges'])) {
                    foreach ($arr[$prop]['edges'] as $commentData) {
                        $this->previewComments[] = Comment::create($commentData['node']);
                    }
                }
                break;
            case 'edge_media_to_comment':
            case 'edge_media_to_parent_comment':
                if (isset($arr[$prop]['count'])) {
                    $this->commentsCount = (int)$arr[$prop]['count'];
                }
                if (isset($arr[$prop]['edges']) && is_array($arr[$prop]['edges'])) {
                    foreach ($arr[$prop]['edges'] as $commentData) {
                        $this->comments[] = Comment::create($commentData['node']);
                    }
                }
                if (isset($arr[$prop]['page_info']['has_next_page'])) {
                    $this->hasMoreComments = (bool)$arr[$prop]['page_info']['has_next_page'];
                }
                if (isset($arr[$prop]['page_info']['end_cursor'])) {
                    $this->commentsNextPage = (string)$arr[$prop]['page_info']['end_cursor'];
                }
                break;

            case 'viewer_has_liked':
                $this->hasLiked = $arr[$prop];
                break;
            case 'edge_media_to_caption':
                if (is_array($arr[$prop]['edges']) && !empty($arr[$prop]['edges'])) {
                    $first_caption = $arr[$prop]['edges'][0];
                    if (is_array($first_caption) && isset($first_caption['node'])) {
                        if (is_array($first_caption['node']) && isset($first_caption['node']['text'])) {
                            $this->caption = $arr[$prop]['edges'][0]['node']['text'];
                        }
                    }
                }
                break;
            case 'edge_sidecar_to_children':
                if (!is_array($arr[$prop]['edges'])) {
                    break;
                }
                foreach ($arr[$prop]['edges'] as $edge) {
                    if (!isset($edge['node'])) {
                        continue;
                    }

                    $this->sidecarMedias[] = static::create($edge['node']);
                }
                break;
            case 'edge_media_to_tagged_user':
                if (!is_array($arr[$prop]['edges'])) {
                    break;
                }
                foreach ($arr[$prop]['edges'] as $edge) {
                    if (!isset($edge['node'])) {
                        continue;
                    }

                    $this->taggedUsers[] = $edge['node']['user'] ?? [];
                    $this->taggedUsersIds[] = $edge['node']['user']['id'] ?? '';
                }

                break;
            case '__typename':
                if ($value == 'GraphImage' || $value == 'GraphStoryImage') {
                    $this->type = static::TYPE_IMAGE;
                } else {
                    if ($value == 'GraphVideo' || $value == 'GraphStoryVideo') {
                        $this->type = static::TYPE_VIDEO;
                    } else {
                        if ($value == 'GraphSidecar') {
                            $this->type = static::TYPE_SIDECAR;
                        }
                    }
                }
                break;
        }
        if (!$this->ownerId && !is_null($this->owner)) {
            $this->ownerId = $this->getOwner()->getId();
        }
    }

    /**
     * @param $mediaArray
     * @param $carouselArray
     * @param $instance
     *
     * @return mixed
     */
    private static function setCarouselMedia($mediaArray, $carouselArray, $instance)
    {
        $carouselMedia = new CarouselMedia();
        switch ($carouselArray['media_type']) {
            case 1:
                $carouselMedia->setType(static::TYPE_IMAGE);
                break;
            case 2:
                $carouselMedia->setType(static::TYPE_VIDEO);
                break;
        }

        if (isset($carouselArray['image_versions2']['candidates'])) {
            // $carouselImages = self::getImageUrls($carouselArray['image_versions2']['candidates'][0]['url']);

            foreach ($carouselArray['image_versions2']['candidates'] as $media) {
                // $mediasUrl[] = $media['src'];
                switch ($media['width']) {
                    case 640:
                        $carouselMedia->setImageThumbnailUrl($media['url']);
                        break;
                    case 750:
                        $carouselMedia->setImageLowResolutionUrl($media['url']);
                        break;
                    case 1080:
                        $carouselMedia->setImageStandardResolutionUrl($media['url']);
                        break;
                }
            }

            $carouselMedia->setImageLowResolutionUrl($carouselArray['image_versions2']['candidates'][5]['url']);
            $carouselMedia->setImageThumbnailUrl($carouselArray['image_versions2']['candidates'][11]['url']);
            $carouselMedia->setImageStandardResolutionUrl($carouselArray['image_versions2']['candidates'][6]['url']);
            $carouselMedia->setImageHighResolutionUrl($carouselArray['image_versions2']['candidates'][0]['url']);
        }

        if ($carouselMedia->getType() === self::TYPE_VIDEO) {
            if (isset($mediaArray['video_views'])) {
                $carouselMedia->setVideoViews($carouselArray['video_views']);
            }
            if (isset($carouselArray['video_versions'])) {
                $carouselMedia->setVideoLowResolutionUrl($carouselArray['video_versions'][2]['url']);
                $carouselMedia->setVideoStandardResolutionUrl($carouselArray['video_versions'][0]['url']);
                $carouselMedia->setVideoLowBandwidthUrl($carouselArray['video_versions'][1]['url']);
            }
        }
        array_push($instance->carouselMedia, $carouselMedia);
        return $mediaArray;
    }

    /**
     * @param string $imageUrl
     *
     * @return array
     */
    private static function getImageUrls($imageUrl)
    {
        $parts = explode('/', parse_url($imageUrl)['path']);
        $imageName = $parts[sizeof($parts) - 1];
        $urls = [
            'thumbnail' => Endpoints::INSTAGRAM_CDN_URL . 't/s150x150/' . $imageName,
            'low' => Endpoints::INSTAGRAM_CDN_URL . 't/s320x320/' . $imageName,
            'standard' => Endpoints::INSTAGRAM_CDN_URL . 't/s640x640/' . $imageName,
            'high' => Endpoints::INSTAGRAM_CDN_URL . 't/' . $imageName,
        ];
        return $urls;
    }

    /**
     * @return Account
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
