import { ADD_CLIENT, EDIT_CLIENT, REMOVE_CLIENT, START_CREATE, START_EDIT, STOP_CREATE, STOP_EDIT } from './client.types'

const INITIAL_STATE = {
  clients: [],
  selectedClient: null,
  isCreating: false,
  isEditing: false
}

const clientReducer = (state = INITIAL_STATE, action) => {
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
      const selectedClient = state.clients.find(e => e.id === action.id)
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
      const updatedClients = [...state.clients]
      const body = {
        action: "addClient",
        creatorid: action.creator,
        name: action.name,
        address: action.address,
        phone: action.phone,
        email: action.email
      }
      fetch('https://localhost/isp/project/controller/Controller.php', {
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
      const updatedClients = [...state.clients]
      // lets make the request
      const body = {
        action: "updateClient",
        id: state.selectedClient.id,
        clientname: action.name,
        clientaddress: action.address,
        clientphone: action.phone,
        clientemail: action.email
      }

      fetch('https://localhost/isp/project/controller/Controller.php', {
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
      const updateClients = [...state.clients]
      // lets make the request
      const body = {
        action: "deleteClient",
        id: action.id
      }
      fetch('https://localhost/isp/project/controller/Controller.php', {
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
  }
}

export default clientReducer