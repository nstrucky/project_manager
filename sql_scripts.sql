
-- Status Codes
insert into status_codes(name, hex_color) values ('Not Started', '#cccccc'), ('In Progress', '#f4ee42'), ('Impl Complete', '#4286f4'), ('Completed', '#41f471'), ('On Hold', '#f9b04f');

-- notes
insert into notes(project_id, content, created_at, updated_at) values ('1', 'some content', '2019-01-01', '2019-01-01'), ('1', 'some more content', '2019-01-05', '2019-01-05'), ('1', 'even more good content', '2019-01-07', '2019-01-07'), ('2', 'content from project 2', '2019-01-07', '2019-01-07'), ('1', 'This is going to be some really long content like I have a lot to say here hopefully its not too much trouble I just dont want this to go unsaid!  Anyway I was telling marge that I went to the store last week and saw Jimmy but he didnt wave at me what a cunt', '2019-01-07', '2019-01-07');


-- tasks
insert into tasks(status, completed, title, start_date, due_date, user_id, project_id, task_template_id)
	values ('In Progress', 0, 'Task 1', '2019-02-01', '2019-02-02', 1, 1, 1),
			('Not Started', 0, 'Task 2', '2019-01-04', '2019-01-05', 1, 1, 1),
			('In Progress', 0, 'Task 3', '2019-02-06', '2019-02-07', 1, 1, 1),
			('In Progress', 0, 'Task 4', '2019-01-01', '2019-01-03', 1, 1, 1);


insert into users(first_name, last_name, job_title) 
	values ('Nick', 'Struckmeyer', 'PM'), 
			('Jeff', 'Girolimon', 'Engineer'),
			('Liz', 'Heinrich', 'Engineer');


