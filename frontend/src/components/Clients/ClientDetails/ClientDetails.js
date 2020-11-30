import React from 'react'
import { connect } from 'react-redux'
import { selectClient } from '../../../redux/client/client.selectors'
import { myContactList, selectContact, selectCreating, selectEditing } from '../../../redux/contact/contact.selectors'
import { myProjectListClient } from '../../../redux/project/project.selectors'
import { deselectClient } from '../../../redux/client/client.actions'
import { addContact, editContact, deleteContact, startEdit, startCreate, stopCreate, stopEdit, fetchContacts } from '../../../redux/contact/contact.actions'
import Modal from '../../Modal/Modal'
import Backdrop from '../../Backdrop/Backdrop'


const mapStateToProps = state => {
  return {
    client: selectClient(state),
    contacts: myContactList(state, selectContact(state).id),
    projects: myProjectListClient(state, selectContact(state).id),
    isEditing: selectEditing(state),
    isCreating: selectCreating(state),
    selectedContact: selectContact(state)
  }
}

const mapDispatchToProps = dispatch => {
  return {
    deselectClient: () => dispatch(deselectClient()),
    addContact: contactData => dispatch(addContact(contactData)),
    editContact: newData => dispatch(editContact(newData)),
    beginCreate: () => dispatch(startCreate()),
    cancelCreate: () => dispatch(stopCreate()),
    beginEdit: id => dispatch(startEdit(id)),
    cancelEdit: () => dispatch(stopEdit()),
    deleteContact: id => dispatch(deleteContact(id)),
    fetchContacts: options => dispatch(fetchContacts(options))
  }
}

class ClientDetails extends React.Component {
  constructor(props) {
    super(props)
    this.firstnameEl = React.createRef()
    this.lastnameEl = React.createRef()
    this.emailEl = React.createRef()
    this.phoneEl = React.createRef()
    this.mainContactEl = React.createRef()
  }

  editContact = () => {
    const contactToEdit = {
      creatorid: 1, // needs to be from the context
      clientid: this.props.selectedClient,
      firstname: this.firstnameEl.current.value,
      lastname: this.lastnameEl.current.value,
      email: this.emailEl.current.value,
      phone: this.phoneEl.current.value,
      maincontact: this.mainContactEl.current.checked ? 1 : 0
    }

    this.props.editContact(contactToEdit)
  }

  addContact = () => {
    const contactToAdd = {
      creatorid: 1, // needs to be from the context
      clientid: this.props.client.id,
      firstname: this.firstnameEl.current.value,
      lastname: this.lastnameEl.current.value,
      email: this.emailEl.current.value,
      phone: this.phoneEl.current.value,
      maincontact: this.mainContactEl.current.checked ? 1 : 0
    }

    this.props.addContact(contactToAdd)
  }

  componentDidMount() {
    this.props.fetchContacts({
      clientId: this.props.selectClient.id
    })
  }

  render() {
    return (
      <div className="details-client">
        {(this.props.isEditing || this.props.isCreating) && <Backdrop />}
        {(this.props.isEditing && this.props.selectedContact) &&
          <Modal
            title="Edit Contact"
            canCancel
            canConfirm
            onCancel={this.props.cancelEdit}
            onConfirm={this.editContact}
            ConfirmText="Save Changes"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="firstname">First Name</label>
                <input type="text" id="firstname" ref={this.firstnameEl} defaultValue={this.props.selectedContact.firstname} required />

                <label htmlFor="lastname">Last Name</label>
                <input type="text" id="lastname" ref={this.lastnameEl} defaultValue={this.props.selectedContact.lastname} required />
              </div>
              <div className="form-control">
                <label htmlFor="email">Email</label>
                <input type="email" id="email" ref={this.emailEl} defaultValue={this.props.selectedContact.email} required />
              </div>
              <div className="form-control">
                <label htmlFor="lastname">Phone</label>
                <input type="phone" id="phone" ref={this.phoneEl} defaultValue={this.props.selectedContact.lastname} required />
              </div>
              <div className="form-control">
                <label htmlFor="lastname">Main Contact?</label>
                <input type="checkbox" id="phone" ref={this.mainContactEl} defaultValue={this.props.selectedContact.maincontact} required />
              </div>
            </form>
          </Modal>
        }

        {this.props.isCreating &&
          <Modal
            title="Add Contact"
            canCancel
            canConfirm
            onCancel={this.props.cancelEdit}
            onConfirm={this.addContact}
            ConfirmText="Add"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="firstname">First Name</label>
                <input type="text" id="firstname" ref={this.firstnameEl} required />

                <label htmlFor="lastname">Last Name</label>
                <input type="text" id="lastname" ref={this.lastnameEl} required />
              </div>
              <div className="form-control">
                <label htmlFor="email">Email</label>
                <input type="email" id="email" ref={this.emailEl} required />
              </div>
              <div className="form-control">
                <label htmlFor="lastname">Phone</label>
                <input type="phone" id="phone" ref={this.phoneEl} required />
              </div>
              <div className="form-control">
                <label htmlFor="lastname">Main Contact?</label>
                <input type="checkbox" id="phone" ref={this.mainContactEl} required />
              </div>
            </form>
          </Modal>
        }
        <button onClick={this.this.props.deselectClient()}>Back</button>
        <h1>{this.this.props.client.name}</h1>
        <h3>{this.this.props.client.phone}</h3>
        <h3>{this.this.props.client.email}</h3>
        <h3>{this.this.props.client.address}</h3>
        <h2>Contacts</h2>
        {this.props.contacts.map(contact => {
          return (
            <div className="contact-item">
              <h4>{contact.firstname} {contact.firstname}</h4>
              <h4>{contact.email}</h4>
              <h4>{contact.phone}</h4>
              <h4>{contact.maincontact ? "Main Contact" : ""}</h4>
              <button onClick={this.props.beginEdit.bind(this, contact.id)}>Edit</button>
              <button onClick={this.props.deleteContact.bind(this, contact.id)}>Delete</button>
            </div>
          )
        })}
        <button onClick={this.props.beginCreate}>Add New Contact</button>
        <h2>Projects</h2>
        {this.props.projects.map(project => {
          return (
            <div className="contact-item">
              <h4>{project.name}</h4>
              <h4>{project.duedate}</h4>
            </div>
          )
        })}
      </div>
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(ClientDetails)

// needs the client selector and contact selector and projects 