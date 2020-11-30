import React from 'react'
import { connect } from 'react-redux'
import { startEdit, removeClient } from '../../../../redux/client/client.actions'

const mapDispatchToProps = dispatch => ({
  edit: id => { dispatch(startEdit(id)) },
  delete: id => { dispatch(removeClient(id)) }
})

const clientItem = props => (
  <div>
    {props.client.name}
    <button onClick={props.edit.bind(this, props.client.id)}>Edit</button>
    <button onClick={props.delete.bind(this, props.client.id)}>Delete</button>
  </div>
)

export default connect(null, mapDispatchToProps)(clientItem)