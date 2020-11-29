import React from 'react'

export default class Clients extends React.Component {
  state = {
    selectedClient: null,
    isAddingClient: false,
    isEditingClient: false,
    contacts: [],
    isAddingContact: false,
    isEditingContact: false
  }
}