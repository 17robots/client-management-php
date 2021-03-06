import React from 'react'
const HomePage = () => (
  <div>
    <h1> Client Management Service </h1>

    <hr />
    <div className="main">
      <section className="instruction">
        <h3> Welcome to our CMS tool! For help on how to use it, please watch the video below. </h3>

        <video controls>
          <source src="" type="video/mp4" />
        </video>
      </section>

      <h3> <u>Technical Information:</u> </h3>
      <section className="documentation">
        <p> Our ISP term project is a client management web application utilizing php and sql
        databases of the type InnoDB. The application allows users to keep track of projects that are
        being worked on and the clients that contracted them. Thus, the application has 6 database tables:
        clients, contacts, milestones, projects, tasks, and users. These tables
        all work to help developers keep track of the development of projects, information on clients,
        and various other utilities. So far, the project consists of various files that can be broken into the
        three following categories: the database itself, the controllers, and the models. Here, the models
        are the various objects in the database, such as the client and project objects, and the controllers
        are the methods that call or change these objects. The architecture we are using for this project is
        the model-view-controller architecture (MVC). MVC helps to separate the application into three
        logical components: the model, the view, and the controller. In our application, the three
        components are implemented as described above, with the database being the model.
        </p>
        <br />
        <h3>Documents: </h3>
        <a href="ISP-Project-Final-Report.pdf" download="ISPReport">Report</a>
        <a href="ISP-Project-Pres.pptx" download="ISPPresentation">Presentation</a>
      </section>
    </div>
  </div>
)

export default HomePage;

