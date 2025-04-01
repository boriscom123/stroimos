<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use AppBundle\Model\OrganizationInterface;
use AppBundle\Model\OrganizationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @UniqueEntity(fields={"name"}, message="Подведомственная организация с таким именем уже существует")
 */
class Owner implements IdentifiableInterface, OrganizationInterface
{
    use IdentifiableTrait, OrganizationTrait;

    const OWNER_STROI_MOS  = 'stroi_mos';
    const OWNER_DGP = 'dgp';
    const OWNER_DGI = 'dgi';
    const OWNER_DSTI = 'dsti';
    const OWNER_DS = 'ds';
    const OWNER_DRNT = 'drnt';
    const OWNER_STROINADZOR = 'stroinadzor';
    const OWNER_MKA = 'mka';
    const OWNER_INVEST = 'invest';
    const OWNER_MKE = 'mke';

    public static $organizations = [
        self::OWNER_STROI_MOS => self::OWNER_STROI_MOS,
        self::OWNER_DGP => self::OWNER_DGP,
        self::OWNER_DGI => self::OWNER_DGI,
        self::OWNER_DSTI => self::OWNER_DSTI,
        self::OWNER_DS => self::OWNER_DS,
        self::OWNER_DRNT => self::OWNER_DRNT,
        self::OWNER_STROINADZOR => self::OWNER_STROINADZOR,
        self::OWNER_MKA => self::OWNER_MKA,
        self::OWNER_INVEST => self::OWNER_INVEST,
        self::OWNER_MKE => self::OWNER_MKE
    ];

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $organization
     * @return bool
     */
    public static function exists($organization)
    {
        return isset(self::$organizations[$organization]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getFormName()
    {
        if($this->name === self::OWNER_DSTI || $this->name === self::OWNER_DGI || $this->name === self::OWNER_DGP || $this->name === self::OWNER_DS || $this->name === self::OWNER_DRNT) {
            return 'департамент';
        }

        return 'комитет';
    }

    public function getSearchName()
    {
        /**
         * TODO: Поиск по owners.name не работал из-за слишком короткого имени, пришлось сделать этот костыль.
         * TODO: Поиск для drnt тоже не работает!
         * Если кто-нибудь осилит разобраться с этой старой версией elastic, то честь вам и хвала
         */
        if($this->name === self::OWNER_DS) {
            return 'dss';
        } elseif ($this->name === self::OWNER_DRNT) {
            return 'department_of_new_territories';
        } elseif ($this->name === self::OWNER_DSTI) {
            return 'department_of_engineering_infrastructure';
        }

        return $this->name;
    }
}
