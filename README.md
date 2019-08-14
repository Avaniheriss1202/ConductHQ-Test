# ConductHQ-Test
ConductHQ Test
Candidate Name: Avani Heriss 
avaniheriss1202@gmail.com
Logic:

	Check If there any new Agent Registered Or only active agent
	If yes, 
o	Then assign lead to that user
	If No, 
o	Get all active user from agent table 
o	check if only one active user
	If Yes
•	assign all leads to them
	If NO
•	And calculate the assigned leads of each Agent
•	Get minimum lead agent_id
•	Check if this agent is previously  assigned lead
o	If yes,
	Get another minimum lead agent
o	if No
	Then assign a lead to that agent
    
