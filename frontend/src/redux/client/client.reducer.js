import { ADD_CLIENT, DESELECT_CLIENT, EDIT_CLIENT, FETCH_CLIENTS, REMOVE_CLIENT, SELECT_CLIENT, START_CREATE, START_EDIT, STOP_CREATE, STOP_EDIT } from './client.types'

const INITIAL_STATE = {
  clients: [],
  selectedClient: null,
  isCreating: false,
  isEditing: false
}

export const clientReducer = (state = INITIAL_STATE, action) => {
  let body
  let updatedClients
  let updateClients
  let selectedClient
  switch (action.type) {
    case START_CREATE:
      return {
        ...state,
        isCreating: true
      }
    case STOP_CREATE:
      return {
        ...state,
        isCreating: false
      }
    case START_EDIT:
      selectedClient = state.clients.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedClient: selectedClient
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedClient: null
      }
    case ADD_CLIENT:
      // lets make the request
      updatedClients = [...state.clients]
      body = {
        action: "addClient",
        creatorid: action.creator,
        name: action.name,
        address: action.address,
        phone: action.phone,
        email: action.email
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
            return
          } else {
            updatedClients.push({
              id: resData.id,
              creator: resData.creatorid,
              name: resData.clientname,
              datecreated: resData.datecreated,
              address: resData.address,
              phone: resData.clientphone,
              email: resData.clientemail
            })
            return
          }
        })
      return {
        ...state,
        isCreating: false,
        clients: updatedClients
      }
    case EDIT_CLIENT:
      updatedClients = [...state.clients]
      // lets make the request
      body = {
        action: "updateClient",
        id: state.selectedClient.id,
        clientname: action.name,
        clientaddress: action.address,
        clientphone: action.phone,
        clientemail: action.email
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
            updatedClients[updatedClients.indexOf(updatedClients.find(e => e.id === state.selectedClient.id))] = {
              ...updatedClients[updatedClients.indexOf(updatedClients.find(e => e.id === action.id))],
              name: resData.clientname,
              address: resData.clientaddress,
              phone: resData.clientphone,
              email: resData.clientemail
            }
          }
        })
      return {
        ...state,
        isEditing: false,
        clients: updatedClients,
        selectedClient: null
      }
    case REMOVE_CLIENT:
      updateClients = [...state.clients]
      // lets make the request
      body = {
        action: "deleteClient",
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
            updatedClients = state.clients.filter(item => item.id !== action.id)
          }
        })
      return {
        ...state,
        selectedClient: null,
        isEditing: false,
        isCreating: null,
        clients: updateClients
      }
    case SELECT_CLIENT:
      selectedClient = state.clients.find(e => e.id === action.id)
      return {
        ...state,
        selectedClient
      }
    case DESELECT_CLIENT:
      return {
        ...state,
        selectedClient: null
      }
    case FETCH_CLIENTS:
      let clients = []
      body = {
        action: "getClients",
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
            clients = resData
          }
        })
      return {
        ...state,
        clients
      }
    default:
      return state
  }
}
