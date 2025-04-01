<?php

namespace AppBundle\Soap\EMoscow\Type;

class HPSMInteractionsFromMosRuInstanceType extends ArrayType
{

    /**
     * @var StringType $ID
     */
    protected $ID = null;

    /**
     * @var Description[] $Description
     */
    protected $Description = null;

    /**
     * @var Resolution[] $Resolution
     */
    protected $Resolution = null;

    /**
     * @var StringType $ResolutionCode
     */
    protected $ResolutionCode = null;

    /**
     * @var StringType $Email
     */
    protected $Email = null;

    /**
     * @var StringType $User
     */
    protected $User = null;

    /**
     * @var StringType $Title
     */
    protected $Title = null;

    /**
     * @var StringType $Status
     */
    protected $Status = null;

    /**
     * @var StringType $Rating
     */
    protected $Rating = null;

    /**
     * @var StringType $ProblemType
     */
    protected $ProblemType = null;

    /**
     * @var DateTimeType $Deadline
     */
    protected $Deadline = null;

    /**
     * @var Feedback[] $Feedback
     */
    protected $Feedback = null;

    /**
     * @var DateTimeType $TimeActualStart
     */
    protected $TimeActualStart = null;

    /**
     * @var DateTimeType $TimeActualEnd
     */
    protected $TimeActualEnd = null;

    /**
     * @var DateTimeType $TimeRegisterd
     */
    protected $TimeRegisterd = null;

    /**
     * @var StringType $UserID
     */
    protected $UserID = null;

    /**
     * @var StringType $Portal
     */
    protected $Portal = null;

    /**
     * @var StringType $SSOID
     */
    protected $SSOID = null;

    /**
     * @var StringType $CK
     */
    protected $CK = null;

    /**
     * @var DateTimeType $TimeAnswered
     */
    protected $TimeAnswered = null;

    /**
     * @var DateTimeType $TimeRequested
     */
    protected $TimeRequested = null;

    /**
     * @var StringType $AdditionalField1
     */
    protected $AdditionalField1 = null;

    /**
     * @var Comments[] $Comments
     */
    protected $Comments = null;

    /**
     * @var AttachmentsType $attachments
     */
    protected $attachments = null;

    /**
     * @var string $query
     */
    protected $query = null;

    /**
     * @var string $uniquequery
     */
    protected $uniquequery = null;

    /**
     * @var string $recordid
     */
    protected $recordid = null;

    /**
     * @var int $updatecounter
     */
    protected $updatecounter = null;

    /**
     * @param string $type
     * @param Description[] $Description
     * @param Resolution[] $Resolution
     * @param Feedback[] $Feedback
     * @param Comments[] $Comments
     * @param string $query
     * @param string $uniquequery
     * @param string $recordid
     * @param int $updatecounter
     */
    public function __construct($type, array $Description, array $Resolution, array $Feedback, array $Comments, $query, $uniquequery, $recordid, $updatecounter)
    {
      parent::__construct($type);
      $this->Description = $Description;
      $this->Resolution = $Resolution;
      $this->Feedback = $Feedback;
      $this->Comments = $Comments;
      $this->query = $query;
      $this->uniquequery = $uniquequery;
      $this->recordid = $recordid;
      $this->updatecounter = $updatecounter;
    }

    /**
     * @return StringType
     */
    public function getID()
    {
      return $this->ID;
    }

    /**
     * @param StringType $ID
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setID($ID)
    {
      $this->ID = $ID;
      return $this;
    }

    /**
     * @return Description[]
     */
    public function getDescription()
    {
      return $this->Description;
    }

    /**
     * @param Description[] $Description
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setDescription(array $Description)
    {
      $this->Description = $Description;
      return $this;
    }

    /**
     * @return Resolution[]
     */
    public function getResolution()
    {
      return $this->Resolution;
    }

    /**
     * @param Resolution[] $Resolution
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setResolution(array $Resolution)
    {
      $this->Resolution = $Resolution;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getResolutionCode()
    {
      return $this->ResolutionCode;
    }

    /**
     * @param StringType $ResolutionCode
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setResolutionCode($ResolutionCode)
    {
      $this->ResolutionCode = $ResolutionCode;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getEmail()
    {
      return $this->Email;
    }

    /**
     * @param StringType $Email
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setEmail($Email)
    {
      $this->Email = $Email;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getUser()
    {
      return $this->User;
    }

    /**
     * @param StringType $User
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setUser($User)
    {
      $this->User = $User;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getTitle()
    {
      return $this->Title;
    }

    /**
     * @param StringType $Title
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTitle($Title)
    {
      $this->Title = $Title;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getStatus()
    {
      return $this->Status;
    }

    /**
     * @param StringType $Status
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getRating()
    {
      return $this->Rating;
    }

    /**
     * @param StringType $Rating
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setRating($Rating)
    {
      $this->Rating = $Rating;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getProblemType()
    {
      return $this->ProblemType;
    }

    /**
     * @param StringType $ProblemType
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setProblemType($ProblemType)
    {
      $this->ProblemType = $ProblemType;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getDeadline()
    {
      return $this->Deadline;
    }

    /**
     * @param DateTimeType $Deadline
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setDeadline($Deadline)
    {
      $this->Deadline = $Deadline;
      return $this;
    }

    /**
     * @return Feedback[]
     */
    public function getFeedback()
    {
      return $this->Feedback;
    }

    /**
     * @param Feedback[] $Feedback
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setFeedback(array $Feedback)
    {
      $this->Feedback = $Feedback;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getTimeActualStart()
    {
      return $this->TimeActualStart;
    }

    /**
     * @param DateTimeType $TimeActualStart
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTimeActualStart($TimeActualStart)
    {
      $this->TimeActualStart = $TimeActualStart;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getTimeActualEnd()
    {
      return $this->TimeActualEnd;
    }

    /**
     * @param DateTimeType $TimeActualEnd
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTimeActualEnd($TimeActualEnd)
    {
      $this->TimeActualEnd = $TimeActualEnd;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getTimeRegisterd()
    {
      return $this->TimeRegisterd;
    }

    /**
     * @param DateTimeType $TimeRegisterd
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTimeRegisterd($TimeRegisterd)
    {
      $this->TimeRegisterd = $TimeRegisterd;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getUserID()
    {
      return $this->UserID;
    }

    /**
     * @param StringType $UserID
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setUserID($UserID)
    {
      $this->UserID = $UserID;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getPortal()
    {
      return $this->Portal;
    }

    /**
     * @param StringType $Portal
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setPortal($Portal)
    {
      $this->Portal = $Portal;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getSSOID()
    {
      return $this->SSOID;
    }

    /**
     * @param StringType $SSOID
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setSSOID($SSOID)
    {
      $this->SSOID = $SSOID;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getCK()
    {
      return $this->CK;
    }

    /**
     * @param StringType $CK
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setCK($CK)
    {
      $this->CK = $CK;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getTimeAnswered()
    {
      return $this->TimeAnswered;
    }

    /**
     * @param DateTimeType $TimeAnswered
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTimeAnswered($TimeAnswered)
    {
      $this->TimeAnswered = $TimeAnswered;
      return $this;
    }

    /**
     * @return DateTimeType
     */
    public function getTimeRequested()
    {
      return $this->TimeRequested;
    }

    /**
     * @param DateTimeType $TimeRequested
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setTimeRequested($TimeRequested)
    {
      $this->TimeRequested = $TimeRequested;
      return $this;
    }

    /**
     * @return StringType
     */
    public function getAdditionalField1()
    {
      return $this->AdditionalField1;
    }

    /**
     * @param StringType $AdditionalField1
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setAdditionalField1($AdditionalField1)
    {
      $this->AdditionalField1 = $AdditionalField1;
      return $this;
    }

    /**
     * @return Comments[]
     */
    public function getComments()
    {
      return $this->Comments;
    }

    /**
     * @param Comments[] $Comments
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setComments(array $Comments)
    {
      $this->Comments = $Comments;
      return $this;
    }

    /**
     * @return AttachmentsType
     */
    public function getAttachments()
    {
      return $this->attachments;
    }

    /**
     * @param AttachmentsType $attachments
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setAttachments($attachments)
    {
      $this->attachments = $attachments;
      return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
      return $this->query;
    }

    /**
     * @param string $query
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setQuery($query)
    {
      $this->query = $query;
      return $this;
    }

    /**
     * @return string
     */
    public function getUniquequery()
    {
      return $this->uniquequery;
    }

    /**
     * @param string $uniquequery
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setUniquequery($uniquequery)
    {
      $this->uniquequery = $uniquequery;
      return $this;
    }

    /**
     * @return string
     */
    public function getRecordid()
    {
      return $this->recordid;
    }

    /**
     * @param string $recordid
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setRecordid($recordid)
    {
      $this->recordid = $recordid;
      return $this;
    }

    /**
     * @return int
     */
    public function getUpdatecounter()
    {
      return $this->updatecounter;
    }

    /**
     * @param int $updatecounter
     * @return \AppBundle\Soap\EMoscow\Type\HPSMInteractionsFromMosRuInstanceType
     */
    public function setUpdatecounter($updatecounter)
    {
      $this->updatecounter = $updatecounter;
      return $this;
    }

}
