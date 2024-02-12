<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $json_data = file_get_contents(__DIR__ . '/testdata.json');
        $json_data = json_decode($json_data, true, 512, JSON_THROW_ON_ERROR);
        $users = $json_data['users'];
        $posts = $json_data['posts'];

        /** @var $user_list User[] */
        $user_list = [];
        foreach ($users as $data) {
            $user = new User();
            $user->setFirstName($data["firstName"]);
            $user->setLastName($data["lastName"]);
            $user->setAddress($data["address"]["state"]);
            $user->setCompany($data["company"]["name"]);
            $user->setEmail($data["email"]);
            $user->setImage($data["image"]);
            $user_list[] = $user;
            $manager->persist($user);
        }

        /** @var $post_list BlogPost[] */
        $post_list = [];
        foreach ($posts as $data) {
            $post = new BlogPost();
            $tags = $data["tags"] ?? [];

            $post->setText($data["body"]);
            $post->setTags(implode(',', $tags));
            $post->setReactions($data["reactions"]);

            # Get a random date
            $dateToday = (new DateTime());
            $randomTimestamp = random_int(0, (new DateTime())->getTimestamp());

            $post->setCreatedDate($randomTimestamp);

            # Get a random user
            $post->setCreatedBy($user_list[array_rand($user_list)]);
            $post_list[] = $post;

        }

        # sort posts by date then persist
        usort($post_list, static function ($previous, $next) {
            return $previous->getCreatedDate() > $next->getCreatedDate();
        });
        foreach ($post_list as $post) {
            $manager->persist($post);
        }
        $manager->flush();
    }
}
