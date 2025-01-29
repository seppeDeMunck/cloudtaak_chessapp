package graph

import "context"

// Resolver struct
type Resolver struct{}

func (r *Resolver) Opening(ctx context.Context) (string, error) {
	return "Opening data", nil
}

func (r *Resolver) Midgame(ctx context.Context) (string, error) {
	return "Midgame data", nil
}

func (r *Resolver) Endgame(ctx context.Context) (string, error) {
	return "Endgame data", nil
}
