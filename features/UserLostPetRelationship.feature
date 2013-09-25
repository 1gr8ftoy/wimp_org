Feature: User/LostPet relationship
  A user should be able to own a LostPet

  Background:
    Given The database is empty
      And I have a user

  Scenario: User has lost pets
    Given I have the following lost pets:
      | petType | petColors | petDescription   | petHomeCity | petHomeState | petImage | contactName | contactEmail   |
      | Dog     | Black     | Spotted, one leg | New York    | NY           | dog.jpg  | John Smith  | john@smith.com |
      | Cat     | Yellow    | Tabby            | Omaha       | NE           | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue  | Macaw            | Corona      | CA           | bird.jpg | Janet Smith | bird@lover.org |

     Then I should have 1 lost "Dog"
      And I should have 1 lost "Cat"
      And I should have 1 lost "Other"

  Scenario: User has three of each type of lost pet
    Given I have the following lost pets:
      | petType | petColors   | petDescription   | petHomeCity | petHomeState | petImage | contactName | contactEmail   |
      | Dog     | Black       | Spotted, one leg | New York    | NY           | dog.jpg  | John Smith  | john@smith.com |
      | Dog     | Brown       | Barks funny      | Manhattan   | NY           | dog.jpg  | John Smith  | john@smith.com |
      | Dog     | Red         | Stands up        | Long Island | NY           | dog.jpg  | John Smith  | john@smith.com |
      | Cat     | Yellow      | Tabby            | Omaha       | NE           | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Cat     | Black/White | Kitten           | Lincoln     | NE           | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Cat     | White       | Very skittish    | Omaha       | NE           | cat.jpg  | Cat Lover   | cat@lover.org  |
      | Other   | Red/Blue    | Macaw            | Corona      | CA           | bird.jpg | Janet Smith | bird@lover.org |
      | Other   | Green       | Sulcata Tortoise | Riverside   | CA           | bird.jpg | Janet Smith | bird@lover.org |
      | Other   | Greem       | Monitor          | Fresno      | CA           | bird.jpg | Janet Smith | bird@lover.org |

     Then I should have 3 lost "Dog"s
      And I should have 3 lost "Cat"s
      And I should have 3 lost "Other"s