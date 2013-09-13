<?php

namespace BConway\WebsiteBundle\Features\Context;

use BConway\WebsiteBundle\Entity\FoundPet;
use BConway\WebsiteBundle\Entity\LostPet;
use BConway\WebsiteBundle\Entity\User;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Event\FeatureEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;
use Behat\CommonContexts\SymfonyMailerContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
   require_once 'PHPUnit/Autoload.php';
   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext //MinkContext if you want to test web
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

        // To use SymfonyMailerContext in your steps
        $this->useContext('symfony_extra', new SymfonyMailerContext());
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /** @BeforeFeature */
    public static function cleanDatabase(FeatureEvent $event)
    {
        $context = new FeatureContext(array());
        $context->theDatabaseIsEmpty();
    }

    /**
     * Returns the Doctrine entity manager.
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function getRepository($repository)
    {
        return $this->getEntityManager()->getRepository($repository);
    }

    protected function findUserByName($name = "TestUser")
    {
        // Return user from the database
        return $this->getRepository('BConwayWebsiteBundle:User')->findOneByUsername($name);
    }

    /**
     * @When /^(?:|I )confirm the popup$/
     */
    public function confirmPopup()
    {
        $this->getSession()->getDriver()->getWebDriverSession()->accept_alert();
    }

    /**
     * @When /^(?:|I )cancel the popup$/
     */
    public function cancelPopup()
    {
        $this->getSession()->getDriver()->getWebDriverSession()->dismiss_alert();
    }

    /**
     * Wait either $duration milliseconds or until jQuery: is undefined or has no active ajax calls AND has no active animations
     *
     * @param int $duration
     */
    protected function jqueryWait($duration = 1000)
    {
        $this->getSession()->wait($duration, '(typeof jQuery === \'undefined\' || (0 === jQuery.active && 0 === jQuery(\':animated\').length))');
    }

    /**
     * @When /^I wait for the response$/
     */
    public function iWaitForTheResponse()
    {
        $this->jqueryWait(20000);
    }

    /**
     * @Given /^The database is empty$/
     */
    public function theDatabaseIsEmpty()
    {
        return array(
            new Given ("There are no found pets in the database"),
            new Given ("There are no lost pets in the database"),
            new Given ("There are no users in the database")
        );
    }

    /**
     * @Given /^There are no found pets in the database$/
     */
    public function thereAreNoFoundPetsInTheDatabase()
    {
        $entities = $this->getEntityManager()->getRepository('BConwayWebsiteBundle:FoundPet')->findAll();

        foreach ($entities as $eachEntity) {
            $this->getEntityManager()->remove($eachEntity);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^There are no lost pets in the database$/
     */
    public function thereAreNoLostPetsInTheDatabase()
    {
        $entities = $this->getEntityManager()->getRepository('BConwayWebsiteBundle:LostPet')->findAll();

        foreach ($entities as $eachEntity) {
            $this->getEntityManager()->remove($eachEntity);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^There are no users in the database$/
     */
    public function thereAreNoUsersInTheDatabase()
    {
        $entities = $this->getEntityManager()->getRepository('BConwayWebsiteBundle:User')->findAll();

        foreach ($entities as $eachEntity) {
            $this->getEntityManager()->remove($eachEntity);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^I have a user(?: named "([^"]*)")?$/
     */
    public function iHaveAUserNamed($arg1 = "TestUser")
    {
        // Create new user object
        $user = new User();

        // Set username and email
        $user->setUsername($arg1);
        $user->setEmail('test' . md5(uniqid('', true) . uniqid('', true)) . '@email.com');

        // Set user as admin
        $user->addRole('ROLE_ADMIN');

        // Get configured encoder, so we can encode the password
        $encoder = $this
            ->kernel
            ->getContainer()
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        // Set user password
        $user->setPassword($encoder->encodePassword('secret', $user->getSalt()));

        $user->setEnabled(true);

        // Get Doctrine entity manager
        $manager = $this->getEntityManager();

        // Save user to database
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * @Given /^I have the following lost pets?:$/
     */
    public function iHaveTheFollowingLostPets(TableNode $table)
    {
        // Get test user
        $user = $this->findUserByName();

        // Get Doctrine entity manager
        $manager = $this->getEntityManager();

        // Parse provided data
        $hash = $table->getHash();

        // Add entity for each in data table
        foreach ($hash as $row) {
            $pet = new LostPet();

            $pet->setPetType($row['petType']);
            $pet->setPetColors($row['petColors']);
            $pet->setPetDescription($row['petDescription']);
            $pet->setPetHomeCity($row['petHomeCity']);
            $pet->setPetHomeState($row['petHomeState']);
            $pet->setContactName($row['contactName']);
            $pet->setContactEmail($row['contactEmail']);

            // Add lost pet to users lost pets array
            $user->addLostPet($pet);

            // Assign user to lost pet entity
            $pet->setUser($user);

            // Save changes to database
            $manager->flush();

            // "Upload" image if it exists in the array
            if (array_key_exists('petImage', $row)) {
                $this->attachFileToManualPost($manager, $pet, 'lost', $row['petImage']);
            }
        }
    }

    /**
     * @Given /^I have the following found pets?:$/
     */
    public function iHaveTheFollowingFoundPets(TableNode $table)
    {
        // Get test user
        $user = $this->findUserByName();

        // Get Doctrine entity manager
        $manager = $this->getEntityManager();

        // Parse provided data
        $hash = $table->getHash();

        // Add entity for each in data table
        foreach ($hash as $row) {
            $pet = new FoundPet();

            $pet->setPetType($row['petType']);
            $pet->setPetColors($row['petColors']);
            $pet->setPetDescription($row['petDescription']);
            $pet->setPetLocationFoundCity($row['petLocationFoundCity']);
            $pet->setPetLocationFoundState($row['petLocationFoundState']);
            $pet->setContactName($row['contactName']);
            $pet->setContactEmail($row['contactEmail']);

            // Add lost pet to users lost pets array
            $user->addFoundPet($pet);

            // Assign user to lost pet entity
            $pet->setUser($user);

            // Save changes to database
            $manager->flush();

            // "Upload" image if it exists in the array
            if (array_key_exists('petImage', $row)) {
                $this->attachFileToManualPost($manager, $pet, 'found', $row['petImage']);
            }
        }
    }

    public function attachFileToManualPost($entityManager, $pet, $postType, $image)
    {
        $unique_filename = sha1(uniqid(mt_rand(), true)) . '.jpg';
        $srcfile=$this->parameters['base_path'] . '/../test_assets/images/' . $image;
        $dstfile=$this->parameters['base_path'] . '/web/uploads/' . $postType . '_pets/' . $pet->getId() . '/' . $unique_filename;
        mkdir(dirname($dstfile), 0777, true);
        if (copy($srcfile, $dstfile)) {
            $pet->setPetImage('/uploads/' . $postType . '_pets/' . $pet->getId() . '/' . $unique_filename);

            // Save changes to database
            $entityManager->flush();
        }
    }
    /**
     * @Then /^I should have (\d+) lost "([^"]*)"s?$/
     */
    public function iShouldHaveOneLost($arg1, $arg2)
    {
        $user = $this->findUserByName();

        $repository = $this->getRepository('BConwayWebsiteBundle:User');

        $pets = array();

        switch ($arg2) {
            case 'Dog':
                $pets = $repository->findLostDogs($user->getId());
                break;
            case 'Cat':
                $pets = $repository->findLostCats($user->getId());
                break;
            case 'Other':
                $pets = $repository->findLostOthers($user->getId());
                break;
            default:
                throw new PendingException('Case not written for ' . $arg2);
                break;

        }

        assertCount((int)$arg1, $pets);
    }

    /**
     * @Then /^I should have (\d+) found "([^"]*)"s?$/
     */
    public function iShouldHaveFound($arg1, $arg2)
    {
        $user = $this->findUserByName();

        $pets = array();

        $repository = $this->getRepository('BConwayWebsiteBundle:User');

        switch ($arg2) {
            case 'Dog':
                $pets = $repository->findFoundDogs($user->getId());
                break;
            case 'Cat':
                $pets = $repository->findFoundCats($user->getId());
                break;
            case 'Other':
                $pets = $repository->findFoundOthers($user->getId());
                break;
            default:
                throw new PendingException('Case not written for ' . $arg2);
                break;

        }

        assertCount((int)$arg1, $pets);
    }

    /**
     * @Given /^I create an account( as "([^"]*)")?$/
     */
    public function iCreateAnAccount($arg1 = "TestUser")
    {
        throw new PendingException();
    }

    /**
     * @Given /^I activate my account$/
     */
    public function iActivateMyAccount()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I post the following lost pets?:$/
     */
    public function iPostTheFollowingLostPets(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I am logged in(?: as "([^"]*)")?$/
     */
    public function iAmLoggedInAs($arg1 = "TestUser")
    {
        throw new PendingException();
    }

    /**
     * @Given /^I post the following found pets?:$/
     */
    public function iPostTheFollowingFoundPets(TableNode $table)
    {
        throw new PendingException();
    }

    /** Click on the element with the provided xpath query
     *
     * @When /^(?:|I )click on the "([^"]*)" element$/
     */
    public function iClickOnTheElement($locator)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('css', $locator); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS selector: "%s"', $locator));
        }

        // ok, let's click on it
        $element->click();
    }

    /**
     * @Given /^I navigate to edit profile$/
     */
    public function iNavigateToEditProfile()
    {
        return array(
            new Given('I follow "Edit my account"'),
            new Then('the "h2" element should contain "Edit User"')
        );
    }
}
