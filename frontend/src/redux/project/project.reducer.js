import { ADD_PROJECT, EDIT_PROJECT, REMOVE_PROJECT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_PROJECT, DESELECT_PROJECT, FETCH_PROJECTS } from './project.types'

const INITIAL_STATE = {
  projects: [],
  isEditing: false,
  isCreating: false,
  selectedProject: null
}

export const projectReducer = (state = INITIAL_STATE, action) => {
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
      const selectedProject = state.projects.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedProject
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedProject: null
      }
    case ADD_PROJECT:
      const updatedProjects = [...state.projects]
      // lets make the request
      const body = {
        action: "addProject",
        creatorid: action.creator,
        clientid: action.clientid,
        name: action.name,
        description: action.description,
        estimatedhours: action.estimatedhours,
        rate: rate,
        paymenttype: action.paymenttype,
        duedate: duedate
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json)
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedProjects.push({
              ...resData
            })
          }
        })
      return {
        ...state,
        isCreating: false,
        projects: updatedProjects
      }
    case EDIT_PROJECT:
      updatedProjects = [...state.projects]
      // lets make the request
      body = {
        action: "updateProject",
        ...action
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json)
        .then(resData => {
          if (resData.error) {
            console.log(error)
            return state
          } else {
            updatedProjects[state.projects.indexOf(state.projects.find(e => e.id === state.selectedProject.id))] = {
              ...updatedProjects[state.projects.indexOf(state.projects.find(e => e.id === state.selectedProject.id))],
              ...action
            }
          }
        })
      return {
        ...state,
        projects: updatedProjects,
        isEditing: false,
        selectedProject: false
      }
    case REMOVE_PROJECT:
      updatedProjects = [...state.projects]
      body = {
        action: "removeProject",
        id: state.selectedProject.id
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
            updatedProjects = updatedProjects.filter(item => item.id !== state.selectedProject.id)
          } else {
            console.log(resData.error)
            return state
          }
        })
      return {
        ...state,
        projects: updatedProjects,
        selectedProject: null
      }
    case SELECT_PROJECT:
      selectedProject = state.projects.find(e => e.id === action.id)
      return {
        ...state,
        selectedProject
      }
    case DESELECT_PROJECT:
      return {
        ...state,
        selectedProject: null
      }
    case FETCH_PROJECTS:
      const projects = []
      body = {
        action: "getProjects",
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
            projects = resData
          }
        })
      return {
        ...state,
        projects
      }
    default:
      return state
  }
}
