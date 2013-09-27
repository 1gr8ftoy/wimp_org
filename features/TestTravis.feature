@behavior @javascript
Feature: A user needs to be able to successfully navigate throughout the website

  @ClearDatabase
  Scenario: User should be able to post lost pets
    Given I have a user
    And I am logged in
    And I navigate to the homepage
    When I post the following lost pets:
      | petType | petBreed | petName  | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
      | Dog     | Yorkie   | Joe      | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |
      | Cat     | Calico   | Garfield | Yellow    | Tabby            | Omaha       | NE           | Omaha, NE           | io7g08gyo97   | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-6556 |
      | Other   | Macaw    | Roger    | Red/Blue  | Macaw            | Corona      | CA           | Corona, CA          | 2woy28yv927et | bird.jpg | Janet Smith | bird@lover.org | (555) 511-2662 |
    And I follow "Edit my posts"
    And I wait until ".reports-grid-tile" is visible
    Then I should see 3 ".reports-grid-tile" elements
    And The database is empty

  @ClearDatabase @SetupWebsiteBehavior
  Scenario: A second user should be able to post lost pets
    Given I have a user named "TestUser2"
    And I am logged in as "TestUser2"
    And I navigate to the homepage
    When I post the following lost pets:
      | petType | petBreed | petName  | petColors | petDescription   | petHomeCity | petHomeState | petLocationLastSeen | petMicrochip  | petImage | contactName | contactEmail   | contactPhone   |
      | Dog     | Yorkie   | Joe      | Black     | Spotted, one leg | New York    | NY           | New York, NY        | a4st8728g2    | dog.jpg  | John Smith  | john@smith.com | (555) 511-2522 |
      | Cat     | Calico   | Garfield | Yellow    | Tabby            | Omaha       | NE           | Omaha, NE           | io7g08gyo97   | cat.jpg  | Cat Lover   | cat@lover.org  | (555) 511-6556 |
      | Other   | Macaw    | Roger    | Red/Blue  | Macaw            | Corona      | CA           | Corona, CA          | 2woy28yv927et | bird.jpg | Janet Smith | bird@lover.org | (555) 511-2662 |
    And I follow "Edit my posts"
    And I wait until ".reports-grid-tile" is visible
    Then I should see 3 ".reports-grid-tile" elements