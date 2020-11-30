import { ADD_CONTACT, REMOVE_CONTACT, EDIT_CONTACT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_CONTACT, DESELECT_CONTACT, FETCH_CONTACTS } from './contact.types'

const INITIAL_STATE = {
  contacts: [],
  selectedContact: null,
  isCreating: false,
  isEditing: false
}

export const contactReducer = (state = INITIAL_STATE, action) => {
  let updatedContacts
  let body
  let selectedContact
  switch (action.type) {
    case ADD_CONTACT:
      updatedContacts = [...state.contacts]
      body = {
        action: "addContact",
        creatorid: action.creator,
        clientid: action.client,
        firstname: action.firstname,
        lastname: action.lastname,
        email: action.email,
        phone: action.phone,
        maincontact: action.maincontact
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedContacts.push({
              id: resData.id,
              creatorid: resData.creatorid,
              clientid: resData.clientid,
              firstname: resData.firstname,
              lastname: resData.lastname,
              email: resData.email,
              phone: resData.phone,
              maincontact: resData.maincontasct
            })
          }
        })
      return {
        ...state,
        contacts: updatedContacts,
        isCreating: false
      }
    case EDIT_CONTACT:
      updatedContacts = [...state.contacts]
      body = {
        action: "editContact",
        id: state.selectedContact.id,
        clientid: action.clientid,
        firstname: action.firstname,
        lastname: action.lastname,
        email: action.email,
        phone: action.phone,
        maincontact: action.maincontact
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedContacts[updatedContacts.indexOf(updatedContacts.find(state.selectedContact.id))] = {
              ...updatedContacts[updatedContacts.indexOf(updatedContacts.find(state.selectedContact.id))],
              clientid: resData.clientid,
              firstname: resData.firstname,
              lastname: resData.lastname,
              email: resData.email,
              phone: resData.phone,
              maincontact: resData.maincontact
            }
          }
        })
      return {
        ...state,
        contacts: updatedContacts,
        isEditing: false,
        selectedContact: null
      }
    case REMOVE_CONTACT:
      updatedContacts = [...state.contacts]
      body = {
        action: "deleteContact",
        id: action.id
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.success) {
            updatedContacts = updatedContacts.filter(item => item.id !== state.selectedContact.id)
          } else {
            console.log(resData.error)
            return state
          }
        })
      return {
        ...state,
        contacts: updatedContacts,
        selectedContact: null
      }
    case START_CREATE:
      return {
        ...state,
        isCreating: true,
      }
    case STOP_CREATE:
      return {
        ...state,
        isCreating: false
      }
    case START_EDIT:
      selectedContact = state.contacts.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedContact
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedContact: null
      }
    case SELECT_CONTACT:
      selectedContact = state.contacts.find(e => e.id === action.id)
      return {
        ...state,
        selectedContact
      }
    case DESELECT_CONTACT:
      return {
        ...state,
        selectedContact: null
      }
    case FETCH_CONTACTS:
      let contacts = []
      body = {
        action: "getContacts",
        options: action.options
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            contacts = resData
          }
        })
      return {
        ...state,
        contacts
      }
    default:
      return state
  }
}
