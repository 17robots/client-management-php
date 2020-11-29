import React from 'react'

const clientDetails = props => (
  <div className="details-client">
    <button onClick={props.onClick}>Back</button>
    <h1>{props.client.name}</h1>
    <h3>{props.client.phone}</h3>
    <h3>{props.client.email}</h3>
    <h3>{props.client.address}</h3>
    <h2>Contacts</h2>
    {props.contacts.map(contact => {
      return (
        <div className="contact-item">
          <h4>{contact.firstname} {contact.firstname}</h4>
          <h4>{contact.email}</h4>
          <h4>{contact.phone}</h4>
          <h4>{contact.main ? "Main Contact" : ""}</h4>
        </div>
      )
    })}
    <h2>Projects</h2>
    {props.projects.map(contact => {
      return (
        <div className="contact-item">
          <h4>{project.name} {contact.firstname}</h4>
          <h4>{project.duedate}</h4>
        </div>
      )
    })}
  </div>
)

export default clientDetails