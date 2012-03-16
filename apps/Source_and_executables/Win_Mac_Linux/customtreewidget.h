// Subclass (header-file) for handling some key events for the list with populated snippets

// Beginning of header-file
#ifndef CUSTOMTREEWIDGET_H
#define CUSTOMTREEWIDGET_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QTreeWidget>
#include <QKeyEvent>
#include <QWidget>

// Beginning of the class
class CustomTreeWidget : public QTreeWidget // Subclass of the qtreewidget, so that we can add extra functionality to the element
{
    Q_OBJECT // A macro for making magic happen, when it comes to calling other classes from a class

// Methods for the class
public:

    // Constructor
    CustomTreeWidget(QWidget *a_parent);

    // Handling keypress events for the list of populated snippets, so the user can switch between
    // snippets with the up and down arrowkeys. The user can even show or hide snippets in a category with
    // left and right arrowkeys
    void keyPressEvent(QKeyEvent *a_event);
};
// Ending of the class

#endif // CUSTOMTREEWIDGET_H
// Ending of header-file
