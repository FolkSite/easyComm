easyComm.grid.Messages = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ec-grid-messages';
    }
    config.record = config.record || {};
    config.record.id = config.record.id || 0;
    Ext.applyIf(config, {
        url: easyComm.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/message/getlist',
            resource_id: config.record.id,
            thread_id: config.thread
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateMessage(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec, ri, p) {
                if(rec.data.deleted) {
                    return 'ec-grid-row-deleted';
                }
                return !rec.data.published ? 'ec-grid-row-disabled' : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true
    });
    easyComm.grid.Messages.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(easyComm.grid.Messages, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);

        var m = [];
        if (ids.length > 1) {
            //m.push({text: _('ticket_comment_viewauthor'),handler: this.viewAuthor});
            //m.push({text: row.published ? _('ticket_comment_unpublish') : _('ticket_comment_publish'),handler: this.publishComment});
            //m.push('-');
            m.push({text: '<i class="x-menu-item-icon icon icon-eye"></i>'+_('ec_messages_publish') ,handler: this.publishMessage});
            m.push({text: '<i class="x-menu-item-icon icon icon-eye-slash"></i>'+_('ec_messages_unpublish') ,handler: this.unpublishMessage});
            m.push('-');
            m.push({text: '<i class="x-menu-item-icon icon icon-remove"></i>'+_('ec_messages_remove'),handler: this.removeMessage});
        } else {
            m.push({text: '<i class="x-menu-item-icon icon icon-edit"></i>'+_('ec_message_update'),handler: this.updateMessage});
            //m.push({text: row.published ? _('ticket_comment_unpublish') : _('ticket_comment_publish'),handler: this.publishComment});
            m.push({
                text: row.data.published ? '<i class="x-menu-item-icon icon icon-eye-slash"></i>'+_('ec_message_unpublish') : '<i class="x-menu-item-icon icon icon-eye"></i>'+_('ec_message_publish'),
                handler: row.data.published ? this.unpublishMessage : this.publishMessage
            });
            m.push('-');
            m.push({
                text: row.data.deleted ? '<i class="x-menu-item-icon icon icon-undo"></i>'+_('ec_message_undelete') : '<i class="x-menu-item-icon icon icon-trash-o"></i>'+_('ec_message_delete'),
                handler: row.data.deleted ? this.undeleteMessage : this.deleteMessage
            });
            m.push({text: '<i class="x-menu-item-icon icon icon-remove"></i>'+_('ec_message_remove'),handler: this.removeMessage});
        }

        this.addContextMenuItem(m);
    },

    createMessage: function (btn, e) {
        var w = MODx.load({
            xtype: 'ec-message-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.reset();
        w.setValues({
            published: true
        });
        w.show(e.target);
    },

    updateMessage: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/message/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'ec-message-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    deleteMessage: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ec_messages_delete')
                : _('ec_message_delete'),
            text: ids.length > 1
                ? _('ec_messages_delete_confirm')
                : _('ec_message_delete_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/message/delete',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },
    undeleteMessage: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ec_messages_undelete')
                : _('ec_message_undelete'),
            text: ids.length > 1
                ? _('ec_messages_undelete_confirm')
                : _('ec_message_undelete_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/message/undelete',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },
    removeMessage: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ec_messages_remove')
                : _('ec_message_remove'),
            text: ids.length > 1
                ? _('ec_messages_remove_confirm')
                : _('ec_message_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/message/remove',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function (r) {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    unpublishMessage: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/message/unpublish',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    publishMessage: function (act, btn, e) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/message/publish',
                ids: Ext.util.JSON.encode(ids)
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    getFields: function (config) {
        return ['id', 'thread', 'thread_name', 'subject', 'date', 'user_name', 'user_email', 'user_contacts', 'text', 'reply_author', 'reply_text', 'published', 'deleted', 'ip'];
    },

    getColumns: function (config) {
        return [{
            header: _('ec_message_id'),
            dataIndex: 'id',
            sortable: true,
            width: 70
        }, {
            header: _('ec_message_thread'),
            dataIndex: 'thread_name',
            sortable: true,
            width: 100
        }, {
            header: _('ec_message_subject'),
            dataIndex: 'subject',
            sortable: true,
            width: 150
        }, {
            header: _('ec_message_date'),
            dataIndex: 'date',
            sortable: true,
            width: 100
        }, {
            header: _('ec_message_user_name'),
            dataIndex: 'user_name',
            sortable: true,
            width: 100
        }, {
            header: _('ec_message_user_email'),
            dataIndex: 'user_email',
            sortable: true,
            width: 100,
            hidden: 1
        }, {
            header: _('ec_message_user_contacts'),
            dataIndex: 'user_contacts',
            sortable: true,
            width: 100,
            hidden: 1
        }, {
            header: _('ec_message_text'),
            dataIndex: 'text',
            sortable: true,
            width: 200
        }, {
            header: _('ec_message_reply_author'),
            dataIndex: 'reply_author',
            sortable: true,
            width: 200
        }, {
            header: _('ec_message_reply_text'),
            dataIndex: 'reply_text',
            sortable: true,
            width: 200
        }, {
            header: _('ec_message_ip'),
            dataIndex: 'ip',
            sortable: true,
            width: 100,
            hidden: 1
        }];
    },

    getTopBar: function (config) {
        return [{
            text: '<i class="icon icon-plus"></i> ' + _('ec_message_create'),
            handler: this.createMessage,
            scope: this
        }, '->', {
            xtype: 'textfield',
            name: 'query',
            width: 200,
            id: config.id + '-search-field',
            emptyText: _('ec_grid_search'),
            listeners: {
                render: {
                    fn: function (tf) {
                        tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
                            this._doSearch(tf);
                        }, this);
                    }, scope: this
                }
            }
        }, {
            xtype: 'button',
            id: config.id + '-search-clear',
            text: '<i class="icon icon-times"></i>',
            listeners: {
                click: {fn: this._clearSearch, scope: this}
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },

    _clearSearch: function (btn, e) {
        this.getStore().baseParams.query = '';
        Ext.getCmp(this.config.id + '-search-field').setValue('');
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('ec-grid-messages', easyComm.grid.Messages);