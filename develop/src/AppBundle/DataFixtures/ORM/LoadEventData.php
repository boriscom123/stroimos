<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Embeddable\Address;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use ExtraBundle\Entity\Event;
use ExtraBundle\Entity\EventAnnounce;
use ExtraBundle\Entity\EventAttachment;
use ExtraBundle\Entity\EventChatMessage;
use ExtraBundle\Entity\VipEventAttachment;
use Faker\Factory;
use Symfony\Component\Finder\Finder;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var EntityManager
     */
    protected $manager;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    public function getOrder()
    {
        return FixturesOrder::L6;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $files = Finder::create()->name('*.*')->in(__DIR__.'/../files/documents');
        $this->countFiles = count($files);

        $this->geoLocations = [
            (new Address())->setText('Ленинградский проспект, 47с2')->setGeoPoint('37.532358,55.798819')->setGeoPolygon('[[[37.53013810720634,55.79949269326854],[37.531076880361546,55.800220918539225],[37.533126088048924,55.79937484639957],[37.531894528487314,55.79848932784075],[37.53013810720634,55.79949269326854]],[],[[37.530569794170475,55.79950877795599],[37.531052591793156,55.79990461978082],[37.53152466057976,55.79973540544946],[37.53169095753871,55.79985627290435],[37.532114746563046,55.79967799327639],[37.531197431079946,55.79915523642126],[37.530569794170475,55.79950877795599]],[[37.53139591454705,55.79902832328915],[37.53233468770228,55.799548060149775],[37.532790663234806,55.799360713944886],[37.531896054158175,55.79869729709268],[37.53139591454705,55.79902832328915]]]'),
            (new Address())->setText('улица Твардовского, 6к5с1')->setGeoPoint('37.384334,55.795089')->setGeoPolygon('[[[37.382293562299296,55.79518117867302],[37.3832108269627,55.79565781358084],[37.3833771239216,55.79555808715437],[37.38294797047926,55.79533747932008],[37.38319473370862,55.795210553698716],[37.38437490567509,55.79575451773705],[37.38546924695324,55.79505642915739],[37.38419251546212,55.79440970384279],[37.383047212212766,55.795122914316565],[37.38312097296067,55.795154645835694],[37.382867504208754,55.795289126749],[37.382449079602466,55.795068517378375],[37.382293562299296,55.79518117867302]],[]]'),
            (new Address())->setText('улица Арбат, 9с1')->setGeoPoint('37.598079,55.751467')->setGeoPolygon('[[[37.444992675781236,55.818805673530136],[37.568588867187486,55.87134573603332],[37.84462036132812,55.83349316477602],[37.804794921874986,55.71118558462815],[37.414780273437486,55.720488295555334],[37.65510620117185,55.790961467580196],[37.444992675781236,55.818805673530136]],[],[[37.62008728027342,55.847016190744625],[37.5857550048828,55.82228479316381],[37.70797790527343,55.79753759758673],[37.694244995117174,55.77354868142686],[37.5857550048828,55.73482561612793],[37.74231018066405,55.73405076099568],[37.81509460449218,55.81687269425157],[37.62008728027342,55.847016190744625]]]'),
        ];

        $videoPlayers = [
            '<iframe width="610" height="343" src="https://www.youtube.com/embed/KdJbxjpuAZ4" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="610" height="343" src="https://www.youtube.com/embed/nhORZ6Ep_jE" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="610" height="343" src="https://www.youtube.com/embed/wyMOYHiatos" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="610" height="343" src="https://www.youtube.com/embed/OX9I1KyNa8M" frameborder="0" allowfullscreen></iframe>',
        ];

        for ($eventNo = 1; $eventNo <= 10; $eventNo++) {
            $this->createEvent($eventNo, $videoPlayers[$eventNo % count($videoPlayers)]);
        }
    }

    private function createEvent($eventNo, $videoPlayerCode)
    {
        $content = '';

        $iteration = rand(2, 4);
        for ($j = 0; $j < $iteration; $j++) {
            $text = $this->faker->paragraph(rand(10, 25), rand(1, 5));
            $content .= "<p>" . mb_convert_case(mb_substr($text, 0, 1, 'utf-8'), MB_CASE_UPPER, 'utf-8')
                . mb_substr($text, 1, null, 'utf-8') . "</p>";
        }

        $newsRow = TextSource::getNewsRow();

        $event = new Event();
        $this->manager->persist($event);
        $event->setTitle($newsRow['name']);
        $event->setTeaser($newsRow['description']);
        $event->setContent($newsRow['text']);
        $event->setPublishable(7 != $eventNo);
        $event->setDate((new \DateTime())->modify("-1 month")->modify(floor($eventNo/10*4)." month")->modify(rand(-5, 5) . " day")->modify(rand(-3, 3) . " hour"));
        $event->setOpen($eventNo % 2);
        $event->setState(($eventNo % 3));
        $event->setGuests([ $this->getReference('user-super-admin') ]);
        $event->setVideoPlayerCode($videoPlayerCode);
        $event->setAddress($this->geoLocations[rand(0, count($this->geoLocations) - 1)]);

        if ($this->faker->boolean(30) || 6 == $eventNo) {
            $this->createEventAnnounce($event, 6 == $eventNo);
        }

        if ($eventNo % 3) {
            for($i=0; $i<=$this->faker->numberBetween(0,3); $i++) {
                $attachment = new EventAttachment();
                $attachment->setFile($this->getFile());
                $attachment->setTitle($this->getTitle());
                $attachment->setEvent($event);
                $event->addAttachment($attachment);
            }
        }

        if ($eventNo % 3) {
            for($i=0; $i<=$this->faker->numberBetween(0,3); $i++) {
                $attachment = new VipEventAttachment();
                $attachment->setFile($this->getFile());
                $attachment->setTitle($this->getTitle());
                $attachment->setEvent($event);
                $event->addVipAttachment($attachment);
            }
        }

        $this->createChatMessages($event);

        $this->manager->flush();
    }

    private function createEventAnnounce($event, $homepage)
    {
        $content = '';

        for ($j = 0; $j < 1; $j++) {
            $text = $this->faker->paragraph(rand(10, 25), rand(1, 5));
            $content .= "<p>" . mb_convert_case(mb_substr($text, 0, 1, 'utf-8'), MB_CASE_UPPER, 'utf-8')
                . mb_substr($text, 1, null, 'utf-8') . "</p>";
        }

        $announce = new EventAnnounce();
        $this->manager->persist($announce);
        $announce->setEvent($event);
        $announce->setHomepage($homepage);
        $announce->setTitle($this->getTitle());
        $announce->setContent($content);
    }

    private function createChatMessages(Event $event)
    {
        for ($i = 0; $i < 30; $i++) {
            $message = new EventChatMessage();
            $this->manager->persist($message);
            $message->setEvent($event);
            $message->setUser($this->getReference('journalist-' . rand(1, 2)));
            $message->setPublishable($this->faker->boolean(90));
            $message->setMessage($this->faker->sentence(rand(3, 10), false));
            $date = clone $event->getDate();
            $message->setCreatedAt($date->modify("-10 month")->modify("$i minute")->modify("$i second"));
        }
    }

    protected function getFile()
    {
        return $this->getReference('media-file-id-' . rand(1, $this->countFiles));
    }

    protected function getTitle()
    {
        return TextSource::getGalleryRow()['name'];
    }
}
