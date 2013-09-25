@behavior @javascript
Feature: A user needs to be able to successfully navigate throughout the website

  Scenario: User needs to be able to view the home page
    Given I am on the homepage
     Then I should see "Have you lost your best friend?"

  @ClearDatabase
  Scenario: User needs to be able to sign up on the website
    Given I am on the homepage
      And I follow "Sign up"
      And I create an account
      And I activate my account
      And I am on the homepage
     Then I should see "Edit my account"

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: A second user needs to be able to sign up on the website
    Given I am on the homepage
      And I follow "Sign up"
      And I create an account as "TestUser2"
      And I activate my account for user "TestUser2"
      And I am on the homepage
     Then I should see "Edit my account"

  @ClearDatabase
  Scenario: User should be able to post lost pets
    Given I have a user
      And I am logged in
      And I am on the homepage
     When I post the following lost pets:
        | petType | petBreed | petName  | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Yorkie   | Joe      | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |
        | Cat     | Calico   | Garfield | Yellow    | Tabby            | Omaha       | NE           | Omaha, NE           | io7g08gyo97   | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-6556 |
        | Other   | Macaw    | Roger    | Red/Blue  | Macaw            | Corona      | CA           | Corona, CA          | 2woy28yv927et | bird.jpg | Janet Smith | bird@lover.org | (555) 511-2662 |
      And I follow "Edit my posts"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 3 ".reports-grid-tile" elements

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: A second user should be able to post lost pets
    Given I have a user named "TestUser2"
      And I am logged in as "TestUser2"
      And I am on the homepage
     When I post the following lost pets:
       | petType | petBreed | petName  | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
       | Dog     | Yorkie   | Joe      | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |
       | Cat     | Calico   | Garfield | Yellow    | Tabby            | Omaha       | NE           | Omaha, NE           | io7g08gyo97   | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-6556 |
       | Other   | Macaw    | Roger    | Red/Blue  | Macaw            | Corona      | CA           | Corona, CA          | 2woy28yv927et | bird.jpg | Janet Smith | bird@lover.org | (555) 511-2662 |
      And I follow "Edit my posts"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 3 ".reports-grid-tile" elements

  @ClearDatabase
  Scenario: User should be able to post found pets
    Given I have a user
      And I am logged in
      And I am on the homepage
      And I post the following found pets:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |
        | Cat     | Calico  | Yellow    | Tabby            | Omaha                | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-7653 |
        | Other   | Macaw   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org | (555) 511-9853 |
      And I follow "Edit my posts"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 3 ".reports-grid-tile" elements

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: A second user should be able to post found pets
    Given I have a user named "TestUser2"
      And I am logged in as "TestUser2"
      And I am on the homepage
      And I post the following found pets:
        | petType | petName | petColors | petDescription   | petLocationFoundCity | petLocationFoundState | petImage | contactName | contactEmail   | contactPhone   |
        | Dog     | Joe     | Black     | Spotted, one leg | New York             | NY                    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2687 |
        | Cat     | Calico  | Yellow    | Tabby            | Omaha                | NE                    | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-7653 |
        | Other   | Macaw   | Red/Blue  | Macaw            | Corona               | CA                    | bird.jpg | Janet Smith | bird@lover.org | (555) 511-9853 |
      And I follow "Edit my posts"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 3 ".reports-grid-tile" elements

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: User needs to be able to view all reported lost pets
    Given I am on the homepage
      And I follow "View lost pets"
      And I wait until "h4" is visible
     Then I should see "Browsing lost pet reports"
      And I wait until ".reports-grid-tile" is visible
      And I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 19 - 24 of 24 total items"
     When I follow "← Previous"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: User needs to be able to view all reported found pets
    Given I am on the homepage
      And I follow "View found pets"
      And I wait until "h4" is visible
     Then I should see "Browsing found pet reports"
      And I wait until ".reports-grid-tile" is visible
      And I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 19 - 24 of 24 total items"
     When I follow "← Previous"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: User needs to be able to filter visible lost pets
    Given I am on the homepage
      And I follow "View lost pets"
     When I wait until ".reports-grid-tile" is visible
      And I press "search_button"
      And I select "All/Any" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 19 - 24 of 24 total items"
     When I follow "← Previous"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I press "search_button"
      And I select "Dog" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should see "Lost dog!"
      And I should not see "Lost cat!"
      And I should not see "Lost pet!"
     When I press "search_button"
      And I select "Cat" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should not see "Lost dog!"
      And I should see "Lost cat!"
      And I should not see "Lost pet!"
     When I press "search_button"
      And I select "Other" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should not see "Lost dog!"
      And I should not see "Lost cat!"
      And I should see "Lost!"
     When I press "reset_search"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: User needs to be able to filter visible found pets
    Given I am on the homepage
      And I follow "View found pets"
     When I wait until ".reports-grid-tile" is visible
      And I press "Search/Filter"
      And I select "All/Any" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I follow "Next →"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 19 - 24 of 24 total items"
     When I follow "← Previous"
      And I wait until ".reports-grid-tile" is visible
     Then I should see "Displaying 10 - 18 of 24 total items"
     When I press "search_button"
      And I select "Dog" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should see "Found dog!"
      And I should not see "Found cat!"
      And I should not see "Found pet!"
     When I press "search_button"
      And I select "Cat" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should not see "Found dog!"
      And I should see "Found cat!"
      And I should not see "Found pet!"
     When I press "search_button"
      And I select "Other" from "form[searchPetType]"
      And I press "submit_search_form"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 8 ".reports-grid-tile" elements
      And I should not see "Found dog!"
      And I should not see "Found cat!"
      And I should see "Found!"
     When I press "reset_search"
      And I wait until ".reports-grid-tile" is visible
     Then I should see 9 ".reports-grid-tile" elements
      And I should see "Displaying 1 - 9 of 24 total items"

  Scenario: User needs to be able to send us a message via the contact page
    Given I am on the homepage
      And I follow "Contact us"
      And I wait until "contact[name]" is visible
     When I fill in "contact[name]" with "Website user"
      And I fill in "contact[email]" with "website@user.com"
      And I fill in "contact[subject]" with "Test message"
      And I fill in "contact[message]" with "This is a test message sent using the contact form"
      And I press "contact[send]"
     Then I should see "Your message has been sent"

  @ClearDatabase
  Scenario: User should be able to logout
    Given I have a user
      And I am logged in
     Then I should not see "Login"
     When I follow "Logout"
     Then I should see "Login"
      And I should not see "Logout"