# Job Posting Platform Backend

## Overview
This project is a job posting platform designed to facilitate the hiring process for recruiters and job seekers. The primary objective is to create a comprehensive and user-friendly backend service that allows recruiters to post job openings and manage applications while job seekers can search for jobs, apply, and interact with job postings.

> [!IMPORTANT]  
> This project was commissioned and is currently incomplete due to several factors. The schema design and database access layer have been completed, but further improvements are needed. The API endpoints are still in progress and require additional development. The project faced time constraints and difficulties with team coordination, which impacted the completion of the project

## Features
- **User Authentication**: Secure user authentication through JSON Web Tokens (JWT), providing a safe and reliable login and registration mechanism.
- **User Profiles**: Users can create and manage their profiles, showcasing their work experience, skills, and other relevant information.
- **User Interactions**: Recruiters and job seekers can interact with job postings by liking and commenting on them.
- **Review Applicants**: Recruiters can review applicant data and profiles for each job post they posted.

## System Architecture
The system architecture is designed to ensure a seamless and efficient user and developer experience, divided into three main components: API, Database (Data Access Layer).

### API
The Application Programming Interface (API) serves as the intermediary between the frontend and backend of the application. Key aspects include:
- **RESTful Endpoints**: Designed with RESTful principles, providing clear and consistent endpoints for various operations such as user authentication, profile management, job postings, and interactions.
- **Authentication**: Secure user authentication is implemented using JSON Web Tokens (JWT), ensuring safe user sessions.
- **Data Handling**: The API handles all data processing by communicating with the data access layer for creating, updating, retrieving, and deleting data.

### Database (Data Access Layer)
The Database (Data Access Layer) is responsible for storing and managing all application data. Key features include:
- **Schema Design**: The database schema is designed to efficiently store information related to users, job postings, applications, interactions, etc.
- **Entity Models**: Each table in the database has a corresponding model (class) that encapsulates the table's structure and implements CRUD (Create, Read, Update, Delete) operations.
- **Data Fetching**: Includes functions and methods for fetching, inserting, updating, and deleting data from the database.
- **Relationships**: Appropriate relationships are established between different entities (e.g., users and job postings, job postings and applications) to maintain data integrity.

## Contributing
Feel free to contribute to this project by submitting issues or pull requests.
