
-- Status Codes
insert into status_codes(name, hex_color) 
	values ('Not Started', '#cccccc'),
		 ('In Progress', '#f4ee42'),
		 ('Impl Complete', '#4286f4'), 
		 ('Completed', '#41f471'), 
		 ('On Hold', '#f9b04f');

-- notes
insert into notes(project_id, content, created_at, updated_at) 
	values ('1', 'some content', '2019-01-01', '2019-01-01'),
		 ('1', 'some more content', '2019-01-05', '2019-01-05'),
		 ('1', 'even more good content', '2019-01-07', '2019-01-07'),
		 ('2', 'content from project 2', '2019-01-07', '2019-01-07'),
		 ('2', 'content from project 2', '2019-01-07', '2019-01-07'),
		 ('2', 'content from project 2', '2019-01-07', '2019-01-07'),
		 ('2', 'content from project 2', '2019-01-07', '2019-01-07'),
		 ('1', 'This is going to be some really long content like I have a lot to say here hopefully its not too much trouble I just dont want this to go unsaid!  Anyway I was telling marge that I went to the store last week and saw Jimmy but he didnt wave at me what a jerk', '2019-01-07', '2019-01-07'),
		 ('1', 'This project has gotten out of control', '2019-01-17', '2019-01-17'),
		 ('1', 'Seriously, someone needs to stop this.', '2019-01-17', '2019-01-17'),
		 ('1', 'Ok I guess it\'s never ending ever', '2019-01-17', '2019-01-17'),
		 ('1', 'This is going to be some really long content like I have a lot to say here hopefully its not too much trouble I just dont want this to go unsaid!  Anyway I was telling marge that I went to the store last week and saw Jimmy but he didnt wave at me what a jerk', '2019-01-18', '2019-01-18'),
		 ('1', 'This project has gotten out of control', '2019-01-18', '2019-01-18'),
		 ('1', 'Seriously, someone needs to stop this.', '2019-01-18', '2019-01-18'),
		 ('1', 'Ok I guess it\'s never ending ever', '2019-01-18', '2019-01-18');


-- tasks
insert into tasks(status, completed, title, start_date, due_date, user_id, project_id, task_template_id)
	values ('In Progress', 0, 'Task 1', '2019-02-01', '2019-02-02', 1, 1, 1),
			('Not Started', 0, 'Task 2', '2019-01-04', '2019-01-05', 1, 1, 1),
			('In Progress', 0, 'Task 3', '2019-02-06', '2019-02-07', 1, 1, 1),
			('In Progress', 0, 'Task 4', '2019-01-01', '2019-01-03', 1, 1, 1);

--users
insert into users(first_name, last_name, job_title) 
	values ('Nick', 'Struckmeyer', 'PM'), 
			('Jeff', 'Girolimon', 'Engineer'),
			('Liz', 'Heinrich', 'Engineer');


--projects
insert into projects(name, account_name, account_number, description, status, work_order, due_date) 
	values ('ADT at Las Palmas', 'Las Palmas HCA', '111111', 'this is just an ADT project', 'In Progress', '123456', '2019-01-29'),
		('Vocera at SJPV', 'St Johns Pleasant V', '222222', 'Some wireless at sjpv', 'On Hold', '234567', '2019-05-05'),
		('Spectralink at Mattawa', 'Mattawa General', '333333', 'Spectralink or something at this place', 'Impl Complete', '345678', '2019-06-05'),
		('OBD at Riverside', 'Riverside University', '444444', 'Outbound bed data at this place', 'Not Started', '456789', '2019-01-01'),
		('Falls Risk at Oreo', 'Oreo University', '555555', 'Falls Risk stuff at Cookie palace', 'In Progress', '567891', '2019-02-06'),
		('AD Integration', 'MH Cypress', '666666', 'This place is a real joy to work with', 'Completed', '678912', '2019-01-20'),
		('Finale at Final', 'Finale Institute', '777777', 'Finally done with everything jesus', 'Completed', '789123', '2019-01-03');	

