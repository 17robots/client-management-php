import { combineReducers } from 'redux'
import { clientReducer } from './client/client.reducer'
import { projectReducer } from './project/project.reducer'
import { taskReducer } from './task/task.reducer'
import { milestoneReducer } from './milestone/milestone.reducer'
import { contactReducer } from './contact/contact.reducer'



const rootReducer = combineReducers({
  client: clientReducer,
  project: projectReducer,
  task: taskReducer,
  milestone: milestoneReducer,
  contact: contactReducer
})

export default rootReducer