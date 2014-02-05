<?php
namespace SocialConnect\Service;

interface Provider
{
    public function getReturnUrlData();
    public function getLoginUrl($returnUrl);
    public function getUserData();
    public function hasErrors();
}