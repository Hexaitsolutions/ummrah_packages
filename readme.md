#API Docs
### Agent APi
1) Signup for agent
name(agent name), email(agent), phone(agent), password,agency_name  Required fields
```   Have to verify email to login
```   Admin has to approve to allow agent to create Packages

2) Signin for agent
 "email" , "password", "role":"agent"     Required , for customer no need to pass role.
```   Have to verify email to login

3) agency-detail/id
``` id = agency id

4) update-agency/id
name (agency name) , phone, photo, password    Optional

``` pass id of agency
``` all fields are optional but can use these fields for updation
PKGs CRUD
5) show agent pkgs
show-packages/agent_id

``` add agent id i.e agent_id in url 
``` pass agent bearer token from signin

6)  create-package
create-package/user_id   // user id in the url
### Fields 
name:testing This Package
duration:2 months
start:2024-01-31
end:2024-03-31
type:hajj
location:xyz
description:This is description
itinary:Random text
price:200000
policy:Policy description
hotel:HotelOne
package_class:first class

``` pass agent bearer token from sign

7) update-agency

update-agency/id
### Fields  all fields are optional pas which u need to update
name:testing This Package
duration:2 months
start:2024-01-31
end:2024-03-31
type:hajj
location:xyz
description:This is description
itinary:Random text
price:200000
policy:Policy description
hotel:HotelOne
package_class:first class

``` id is pkg id
``` pass agent bearer token from sign


8) show agency
