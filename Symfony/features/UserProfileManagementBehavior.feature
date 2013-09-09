@behavior
Feature: User profile
  User needs to be able to
  modify their profile

  Background:
    Given The database is empty
      And I have a user
      And I am logged in
     Then I should be on the homepage

  Scenario: User logs in
    Given I should see "Logout"

  Scenario: User logs out
    Given I follow "Logout"
     Then I should see "Login"

  Scenario: User unsuccessfully tries to change password
    Given I navigate to edit profile
     When I follow "Change password"
      And I fill in "fos_user_change_password_form_current_password" with "wrongpassword"
      And I fill in "fos_user_change_password_form_plainPassword_first" with "newPassword"
      And I fill in "fos_user_change_password_form_plainPassword_second" with "newPassword"
      And I press "Change password"
     Then I should see "This value should be the user current password."

  Scenario: User successfully changes password
    Given I navigate to edit profile
     When I follow "Change password"
      And I fill in "fos_user_change_password_form_current_password" with "secret"
      And I fill in "fos_user_change_password_form_plainPassword_first" with "newPassword"
      And I fill in "fos_user_change_password_form_plainPassword_second" with "newPassword"
      And I press "Change password"
     Then I should see "Password changed successfully"

  Scenario: User unsuccessfully tries to change username
    Given I have a user named "TestUser2"
      And I navigate to edit profile
     When I fill in "fos_user_profile_form_username" with "TestUser2"
      And I fill in "fos_user_profile_form_current_password" with "secret"
      And I press "Update"
     Then I should see "The username is already used"

  Scenario: User successfully changes username
     Given I navigate to edit profile
      When I fill in "fos_user_profile_form_username" with "TestUser2"
      And I fill in "fos_user_profile_form_current_password" with "secret"
      And I press "Update"
     Then I should see "Profile updated successfully"

  Scenario: User successfully changes email address
    Given I navigate to edit profile
     When I fill in "fos_user_profile_form_email" with "new_email@email.com"
      And I fill in "fos_user_profile_form_current_password" with "secret"
      And I press "Update"
     Then I should see "Profile updated successfully"

  Scenario: User deletes their account
    Given I navigate to edit profile
     When I follow "Delete my account"
      And I fill in "form-password" with "secret"
      And I press "Confirm account deletion"
     Then I should see "Your account has been deleted successfully"
      And I should see "Login"
      And I should not see "Logout"